@extends('layouts.main')

@section('content')
    <body>
    <div class="container">
        <div class="row">
            <div class="col-md-offset-3 col-md-6">
                <form id="form_submit" name="form_submit" method="post" action="{{ url("act_login") }}" class="form-horizontal">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <span class="heading">登录</span>
                    <div class="form-group">
                        <input type="text" autofocus="autofocus" class="form-control" id="user_name" name="user_name" placeholder="用户名" tabindex="1"/>
                        <i class="fa fa-user"></i>
                    </div>
                    <div class="form-group help">
                        <input type="password" class="form-control" id="password" name="password" placeholder="密码" tabindex="2">
                        <i class="fa fa-lock"></i>
                    </div>
                    <div class="form-group">
                        <div class="main-checkbox">
                            <input type="checkbox" value="0" id="remember" name="remember" tabindex="3"/>
                            <label for="remember"></label>
                        </div>
                        <span class="text">记住我</span>
                        <button type="submit" class="btn btn-default" tabindex="4">登录</button>
                    </div>
                    <div class="form-group help">
                        <a href="{{ url("register") }}">无账号？去注册</a>
                    </div>
                    @if (count($errors) > 0)
                    <div class="form-group help">
                        <div class="alert alert-info">
                            {{ $errors->first() }}
                        </div>
                    </div>
                    @endif
                </form>
            </div>
        </div>
    </div>
    </body>
@endsection