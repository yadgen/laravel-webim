<?php

namespace App\Console\Commands\Swoole;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Redis;

use App\Console\Commands\Swoole\Storage\WebSocketStorage;

#todo 优化$ws全局变量
class WebSocket extends Command
{
    protected $signature = 'swoole:websocket';

    protected $description = 'Swoole WebSocket Server';

    protected $serv;

    public function __construct()
    {
        parent::__construct();

        Redis::flushdb();
    }

    public function handle()
    {
        $this->info('swoole websocket started');

        $this->serv = new \Swoole\WebSocket\Server(config('swoole.websocket.host'), config('swoole.websocket.port'));

        $this->serv->set([
            'log_file' => '/var/www/html/webim/swoole.log',
            'worker_num' => 1,
            'task_worker_num' => 1,
            'debug_mode' => 1,
        ]);

        $this->serv->on('open', function ($ws, $request) {
            echo "client-{$request->fd} is opened\n";
        });

        $this->serv->on('close', function ($ws, $fd) {
            $user = WebSocketStorage::getUser($fd);
            if ($user) {
                $retMsg = [
                    'cmd' => 'offline',
                    'fd' => $fd,
                    'channel' => 0,
                    'message' => $user['user_name'] . '下线了',
                    'time' => date('Y-m-d H:i:s')
                ];
                WebSocketStorage::logout($fd);

                $this->broadcastJson($ws, $fd, $retMsg);
            }
        });

        $this->serv->on('message', function ($ws, $frame) {
            $client_id = $frame->fd;
            $frameData = json_decode($frame->data, true);

            if ($frameData['cmd'] == 'login') {
                $this->cmd_login($ws, $client_id, $frameData);
            } elseif ($frameData['cmd'] == 'getOnline') {
                $this->cmd_getOnline($ws, $client_id, $frameData);
            } elseif ($frameData['cmd'] == 'message') {
                $this->cmd_message($ws, $client_id, $frameData);
            }
        });

        $this->serv->on('task', function($ws, $task_id, $from_id, $data) {
            echo "This Task {$task_id} from Worker {$from_id}\n";

            $start_fd = 0;
            while(true)
            {
                $conn_list = $ws->connection_list($start_fd, 10);
                if($conn_list === false || count($conn_list) === 0)
                {
                    echo "finish\n";
                    break;
                }
                $start_fd = end($conn_list);
                foreach($conn_list as $fd)
                {
                    $ws->push($fd, json_en($data));
                }
            }

            return "Task {$task_id}'s result";
        });

        $this->serv->on('finish', function($ws, $task_id, $data) {
            echo "Task {$task_id} finish\n";
            echo "Result: {$data}\n";
        });

        $this->serv->start();
    }

    public function cmd_login($ws, $client_id, $msg)
    {
        $resMsg = [
            'cmd' => 'login',
            'fd' => $client_id,
            'user_id' => $msg['user_id'],
            'user_name' => $msg['user_name'],
            'user_avatar' => $msg['user_avatar'],
        ];
        WebSocketStorage::login($client_id, $resMsg);
        $ws->push($client_id, json_en($resMsg));

        // 广播给其他在线用户
        $resMsg['cmd'] = 'newUser';
        $this->broadcastJson($ws, $client_id, $resMsg);

        $loginMsg = [
            'cmd' => 'fromMsg',
            'channel' => 0,
            'message' => $msg['user_name'] . "上线了",
            'time' => date('Y-m-d H:i:s')
        ];
        $this->broadcastJson($ws, $client_id, $loginMsg);
    }

    public function cmd_getOnline($ws, $client_id, $msg)
    {
        $resMsg = [
            'cmd' => 'getOnline',
        ];

        $users = WebSocketStorage::getOnlineUsers();
        $list = WebSocketStorage::getUsers($users);

        $resMsg['users'] = $users;
        $resMsg['list'] = $list;

        $ws->push($client_id, json_en($resMsg));
    }

    public function cmd_message($ws, $client_id, $msg)
    {
        $user = WebSocketStorage::getUser($client_id);

        if ($user) {
            $retMsg = [
                'cmd' => 'fromMsg',
                'channel' => 1,
                'user_name' => $user['user_name'],
                'user_avatar' => $user['user_avatar'],
                'message' => $msg['message'],
                'time' => date('Y-m-d H:i:s'),
            ];
            $ws->task($retMsg);
        }
    }

    public function broadcastJson($ws, $session_id, $array)
    {
        $msg = json_en($array);
        $this->broadcast($ws, $session_id, $msg);
    }

    public function broadcast($ws, $current_session_id, $msg)
    {
        $users = WebSocketStorage::getOnlineUsers();
        $list = WebSocketStorage::getUsers($users);

        foreach ($list as $v) {
            if ($current_session_id != $v['fd']) {
                $ws->push($v['fd'], $msg);
            }
        }
    }
}
