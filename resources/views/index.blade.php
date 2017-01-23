@extends('layouts.main')

@section('content')
<body>
    <div class="container">
        <div class="row" style="margin-top:15px;">

            <!-- 聊天区 -->
            <div class="col-sm-8">
                <!-- 聊天内容 -->
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <span class="glyphicon glyphicon-earphone"></span>
                        &nbsp;程序员的那点事儿
                    </div>
                    <div class="panel-body chat-body">
                        <div class="message-list-body" id="message_list">
                            {{--<div class="clearfix msg-wrap">--}}
                                {{--<div class="msg-head">--}}
                                    {{--<span class="msg-name label label-primary pull-left">--}}
                                        {{--<span class="glyphicon glyphicon-user"></span>--}}
                                        {{--&nbsp;Sc千寻--}}
                                    {{--</span>--}}
                                    {{--<span class="msg-time label label-default pull-left">--}}
                                        {{--<span class="glyphicon glyphicon-time"></span>--}}
                                        {{--&nbsp;21:34:15--}}
                                    {{--</span>--}}
                                {{--</div>--}}
                                {{--<div class="msg-content">test</div>--}}
                            {{--</div>--}}
                        </div>
                    </div>
                </div>

                <!-- 输入框 -->
                <div class="input-group input-group-lg">
                    <span class="input-group-btn">
                        <button class="btn btn-default" id="emotion" type="button">
                            <img src="{{ asset('images/emotion_smile.png') }}" style="width:24px;height:24px;">
                        </button>
                    </span>
                    <input type="text" class="form-control" id="message" placeholder="请输入聊天内容">
                    <span class="input-group-btn" id="send">
                        <button class="btn btn-default" type="button">
                            发送
                            <span class="glyphicon glyphicon-send"></span>
                        </button>
                    </span>
                </div>
            </div>

            <!-- 个人信息 -->
            <div class="col-sm-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <span class="glyphicon glyphicon-user"></span>
                        &nbsp;个人信息
                    </div>
                    <div class="panel-body">
                        <div class="col-sm-9">
                            <h5 id="my-nickname">昵称：{{ $user->user_name }}</h5>
                        </div>
                        <div class="col-sm-3">
                            <a href="{{ url('logout') }}" class="btn btn-default">退出</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 在线列表 -->
            <div class="col-sm-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <span class="glyphicon glyphicon-list"></span>
                        &nbsp;在线名单
                    </div>
                    <div class="panel-body list-body">
                        <table class="table table-hover list-table" id="online_user_list">
                            {{--<tr>--}}
                                {{--<td>test</td>--}}
                            {{--</tr>--}}
                        </table>
                    </div>
                    <div class="panel-footer" id="list-count">当前在线：<span id="online_user_list_count">0</span>人</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="login-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true">&times;</span>
                        <span class="sr-only"></span>
                    </button>
                    <h4 class="modal-title" id="myModalLabel">请设置聊天昵称</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-8 col-sm-push-2">
                            <div class="alert alert-danger" role="alert" id="nickname-error" style="display: none">
                                <span class="glyphicon glyphicon-remove"></span>
                                请填写昵称
                            </div>
                            <div class="input-group">
                                <span class="input-group-addon">昵称</span>
                                <input type="text" id="nickname-edit" class="form-control" placeholder="请输入昵称">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" onclick="onClickApplyNickname()">应用昵称</button>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript" src="{{ URL::asset("js/lib/jquery-3.1.1.js") }}"></script>
    <script type="text/javascript" src="{{ URL::asset("js/lib/jquery.WebSocket.js") }}"></script>
    <script type="text/javascript" src="{{ URL::asset("js/lib/jquery.json.js") }}"></script>
    <script type="text/javascript" src="{{ URL::asset("js/lib/emotion.js") }}"></script>
    <script type="text/javascript">
        var server_addr = "127.0.0.1";
        var port = "9501";
        var app_url = "{{ $app_url }}";
        var user_id = "{{ $user->id }}";
        var user_name = "{{ $user->user_name }}";
    </script>
    <script type="text/javascript" src="{{ URL::asset("js/index.js") }}"></script>
</body>
@endsection