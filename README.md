# Laravel Swoole Chat Room

基于 Laravel Framework 和 Swoole 开发的聊天室

## Installation && Configuration

导入根目录下的表信息 cr_user.sql

拷贝一份 .env.example 并改名 .env，配置 redis，db 信息

启动 redis

## Usage

根目录执行以下命令即可启动服务:

`php artisan swoole:websocket`