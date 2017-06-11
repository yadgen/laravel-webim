<?php

namespace App\Console\Commands\Swoole;

use Illuminate\Console\Command;

class WebSocket extends Command
{
    protected $signature = 'swoole:websocket';

    protected $description = 'Swoole WebSocket Server';

    private $serv;
    private $redis;

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $this->info('swoole websocket started');

        $d = [];

        $d['qqface'] = [
            '疑问' => '1.gif',
            '亲亲' => '3.gif',
            '尴尬' => '4.gif',
            '啤酒' => '5.gif',
            '吃饭' => '6.gif',
            '灯泡' => '7.gif',
            '困' => '8.gif',
            '抓狂' => '9.gif',
            '奋斗' => '10.gif',
            'ok' => '11.gif',
            '折磨' => '12.gif',
            '委屈' => '13.gif',
            '嘘' => '14.gif',
            '妩媚' => '15.gif',
            '刀' => '16.gif',
            '饥饿' => '17.gif',
            '闭嘴' => '18.gif',
            '爱你' => '19.gif',
            '口罩' => '20.gif',
            '猪头' => '21.gif',
            '难过' => '22.gif',
            '鄙视' => '23.gif',
            '蛋糕' => '24.gif',
            '哈欠' => '25.gif',
            '微笑' => '36.gif',
            '流泪' => '41.gif',
            '调皮' => '44.gif',
            '阴险' => '40.gif',
            '大笑' => '85.gif',
            '晕倒' => '96.gif',
            '白眼' => '80.gif',
            '脸红' => '75.gif'
        ];

        $d['swoole_fd_key'] = 'swoole_fd';
        $d['swoole_fd_user_key'] = 'swoole_fd_user';
        $d['swoole_online_user_list_key'] = 'swoole_online_user_list';

        $this->redis = new \Redis();
        $this->redis->connect('127.0.0.1', 6379);
        $this->redis->auth('123456');
        $this->redis->select(1);
        $this->redis->flushdb();

// 在线列表模版
        $d['template_online'] = <<<EOT
<tr class="online_user_list_{user_id}">
    <td>{user_name}</td>
</tr>
EOT;
// 聊天内容模版
        $d['template_message_user'] = <<<EOT
<div class="clearfix msg-wrap">
    <div class="msg-head">
        <span class="msg-name label label-primary pull-left">
            <span class="glyphicon glyphicon-user"></span>
            &nbsp;{user_name}
        </span>
        <span class="msg-time label label-default pull-left">
            <span class="glyphicon glyphicon-time"></span>
            &nbsp;{reply_time}
        </span>
    </div>
    <div class="msg-content">{message}</div>
</div>
EOT;
// 系统内容模版
        $d['template_system_message'] = <<<EOT
<div class="clearfix msg-wrap">
    <div class="msg-head">
        <span class="msg-name label label-danger pull-left">
            <span class="glyphicon glyphicon-info-sign"></span>
            &nbsp;&nbsp;系统消息
        </span>
        <span class="msg-time label label-default pull-left">
            <span class="glyphicon glyphicon-time"></span>
            &nbsp;&nbsp;{reply_time}
        </span>
    </div>
    <div class="msg-content">欢迎来到酱油聊天室！</div>
</div>
EOT;

        $this->serv = new \Swoole\WebSocket\Server('127.0.0.1', 9501);

        $this->serv->set([
            'worker_num' => 8,
            'daemonize' => false,
            'max_request' => 10000,
            'dispatch_mode' => 2,
            'debug_mode' => 1,
        ]);

        $this->serv->on('open', function ($ws, $request) use ($d) {
            $this->redis->sadd($d['swoole_fd_key'], $request->fd);

            echo "client-{$request->fd} is opened\n";
        });

        $this->serv->on('close', function ($ws, $fd) use ($d) {
            $this->redis->srem($d['swoole_fd_key'], $fd);

            $fd_user = $this->redis->hgetall($d['swoole_fd_user_key']);
            $user_id = $fd_user[$fd];
            $this->redis->hdel($d['swoole_fd_user_key'], $fd);

            $this->redis->hdel($d['swoole_online_user_list_key'], $user_id);

            // 告诉其他人，某人退出了
            $fdList = $this->redis->smembers($d['swoole_fd_key']);
            $fdCount = count($fdList);
            foreach ($fdList as $fd) {
                $data = [
                    'message_type' => 2,
                    'user_id' => $user_id,
                    'online_user_list_count' => $fdCount,
                ];
                $ws->push($fd, json_encode($data, JSON_UNESCAPED_UNICODE));
            }

            echo "client-{$fd} is closed\n";
        });

        $this->serv->on('message', function ($ws, $frame) use ($d) {
            $frameData = json_decode($frame->data, true);
            $fdList = $this->redis->smembers($d['swoole_fd_key']);
            $fdCount = count($fdList);
            $reply_time = date('Y-m-d H:i:s');

            switch ($frameData['message_type']) {
                case 1: // onopen
                    $this->redis->hset($d['swoole_online_user_list_key'], $frameData['user_id'], $frameData['user_name']);
                    $this->redis->hset($d['swoole_fd_user_key'], $frame->fd, $frameData['user_id']);

                    // 告诉其他人，某人进来了
                    foreach ($fdList as $fd) {
                        if ($frame->fd != $fd) {
                            $message = str_replace(
                                ['{user_id}', '{user_name}'],
                                [$frameData['user_id'], $frameData['user_name']],
                                $d['template_online']
                            );
                            $data = [
                                'message_type' => $frameData['message_type'],
                                'message' => $message,
                                'online_user_list_count' => $fdCount,
                            ];

                            $ws->push($fd, json_encode($data, JSON_UNESCAPED_UNICODE));
                        }
                    }

                    // 告诉自己，有哪些人
                    $user_list = $this->redis->hgetall($d['swoole_online_user_list_key']);
                    foreach ($user_list as $user_id => $user_name) {
                        $message = str_replace(
                            ['{user_id}', '{user_name}'],
                            [$user_id, $user_name],
                            $d['template_online']
                        );
                        $data = [
                            'message_type' => $frameData['message_type'],
                            'message' => $message,
                            'online_user_list_count' => $fdCount,
                        ];
                        $ws->push($frame->fd, json_encode($data, JSON_UNESCAPED_UNICODE));
                    }
                    break;
                case 2:
                    echo 'message_type:' . $frameData['message_type'];
                    break;
                case 3: // 用户消息
                    $frameData['message'] = htmlspecialchars($frameData['message']);
                    foreach ($fdList as $fd) {
                        foreach ($d['qqface'] as $k => $v) {
                            $frameData['message'] = str_replace("[#" . $k . "]", "<img src='" . $frameData['app_url'] . "/images/qqface/" . $v . "'>", $frameData['message']);
                        }

                        $message = str_replace(
                            ['{user_name}', '{reply_time}', '{message}'],
                            [$frameData['user_name'], $reply_time, $frameData['message']],
                            $d['template_message_user']
                        );
                        $data = [
                            'message_type' => $frameData['message_type'],
                            'message' => $message,
                        ];
                        $ws->push($fd, json_encode($data, JSON_UNESCAPED_UNICODE));
                    }
                    break;
                case 4: // 系统消息
                    // 发送系统通知
                    $message = str_replace(
                        ['{user_id}', '{reply_time}', '{user_name}'],
                        [$frameData['user_id'], $reply_time, $frameData['user_name']],
                        $d['template_system_message']
                    );
                    $data = [
                        'message_type' => 4,
                        'message' => $message,
                    ];
                    $ws->push($frame->fd, json_encode($data, JSON_UNESCAPED_UNICODE));
                    break;
                default:
                    echo "message_type error:" . $frameData['message_type'];
                    break;
            }
        });

        $this->serv->start();
    }
}
