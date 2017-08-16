@extends('layouts.main')

@section('content')
    <body>
    <div id="container">
        <div id="content-header">
            <h1>Swoole WebIM</h1>
        </div>
        <div class="container-fluid">
            <div class="row-fluid">
                <div class="span12">
                    <div class="widget-box widget-chat">
                        <div class="widget-title">
                            <h5>聊天记录</h5>
                        </div>
                        <div class="widget-content nopadding">
                            <div class="chat-content panel-left">
                                <div class="chat-messages" id="chat-messages">
                                    <div id="chat-messages-inner" class="msgList">
                                        {{--<p>--}}
                                            {{--<img src="{{ asset('images/avatar/monsterid/c4/ca/1_64.png') }}">--}}
                                            {{--<span class="msg-block">--}}
                                                {{--<strong>Neytiri</strong>--}}
                                                {{--<span class="time"> 2017.10.10 23:10:10</span>--}}
                                                {{--<span class="msg">I have a problem. My computer not work!</span>--}}
                                            {{--</span>--}}
                                        {{--</p>--}}
                                        {{--<p>--}}
                                            {{--<img src="{{ asset('images/avatar/monsterid/c4/ca/1_64.png') }}">--}}
                                            {{--<span class="msg-block">--}}
                                                {{--<strong>Cartoon Man</strong>--}}
                                                {{--<span class="time"> 2017.10.10 23:10:10</span>--}}
                                                {{--<span class="msg">Turn off and turn on your computer then see result.</span>--}}
                                            {{--</span>--}}
                                        {{--</p>--}}
                                        {{--<p class="offline success">--}}
                                            {{--<span>成功<i class="time"> 2017.10.10 23:10:10</i></span>--}}
                                        {{--</p>--}}
                                        {{--<p class="offline info">--}}
                                            {{--<span>提示<i class="time"> 2017.10.10 23:10:10</i></span>--}}
                                        {{--</p>--}}
                                        {{--<p class="offline warning">--}}
                                            {{--<span>警告<i class="time"> 2017.10.10 23:10:10</i></span>--}}
                                        {{--</p>--}}
                                        {{--<p class="offline danger">--}}
                                            {{--<span>错误<i class="time"> 2017.10.10 23:10:10</i></span>--}}
                                        {{--</p>--}}
                                    </div>
                                </div>
                                <div class="chat-message well">
                                    <button class="btn btn-success" id="send">Send</button>
                                    <span class="input-box">
                                        <input type="text" name="message" id="message" class="form-control">
                                    </span>
                                </div>
                            </div>
                            <div class="chat-users panel-right">
                                <div class="panel-title">
                                    <h5>
                                        在线用户
                                        <i class="online_user_count" style="padding-left: 3px;">0</i>
                                    </h5>
                                </div>
                                <div class="panel-content nopadding">
                                    <ul class="contact-list userList">
                                        {{--<li id="user-michelle" class="online new">--}}
                                            {{--<a href="#">--}}
                                                {{--<img src="{{ asset('images/avatar/monsterid/c4/ca/1_64.png') }}">--}}
                                                {{--<span>Michelle</span>--}}
                                            {{--</a>--}}
                                            {{--<span class="msg-count badge badge-info">3</span>--}}
                                        {{--</li>--}}
                                        {{--<li id="user-cartoon-man" class="online">--}}
                                            {{--<a href="#">--}}
                                                {{--<img src="{{ asset('images/avatar/monsterid/c4/ca/1_64.png') }}">--}}
                                                {{--<span>Cartoon Man</span>--}}
                                            {{--</a>--}}
                                        {{--</li>--}}
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript" src="{{ URL::asset("js/lib/jquery.WebSocket.js") }}"></script>
    <script type="text/javascript" src="{{ URL::asset("js/lib/jquery.json.js") }}"></script>
    <script type="text/javascript">
        var server = "127.0.0.1";
        var port = "9501";
        var user = {!! json_en($user) !!};
    </script>
    <script type="text/javascript" src="{{ URL::asset("js/index.js") }}"></script>
    </body>
@endsection