<?php

namespace app\Console\Commands\Swoole\Storage;

use Illuminate\Support\Facades\Redis;

class WebSocketStorage
{
    protected $redis;

    const PREFIX = 'webim';

    public static function login($client_id, $info)
    {
        Redis::set(self::PREFIX . ':client:' . $client_id, json_en($info));
        Redis::sadd(self::PREFIX . ':online', $client_id);
    }

    public static function logout($client_id)
    {
        Redis::del(self::PREFIX . ':client:' . $client_id);
        Redis::srem(self::PREFIX . ':online', $client_id);
    }

    public static function getOnlineUsers()
    {
        return Redis::smembers(self::PREFIX . ':online');
    }

    public static function getUsers($users)
    {
        $keys = [];
        $ret = [];

        foreach ($users as $v)
        {
            $keys[] = self::PREFIX . ':client:' . $v;
        }

        $info = Redis::mget($keys);
        foreach ($info as $v)
        {
            $ret[] = json_decode($v, true);
        }

        return $ret;
    }

    public static function getUser($client_id)
    {
        $ret = Redis::get(self::PREFIX . ':client:' . $client_id);
        $info = json_decode($ret, true);

        return $info;
    }
}