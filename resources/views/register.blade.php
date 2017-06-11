@extends('layouts.main')

@section('content')
<body>
    <div class="login">
        <i ripple>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                <path fill="#C7C7C7" d="m12,2c-5.52,0-10,4.48-10,10s4.48,10,10,10,10-4.48,10-10-4.48-10-10-10zm1,17h-2v-2h2zm2.07-7.75-0.9,0.92c-0.411277,0.329613-0.918558,0.542566-1.20218,1.03749-0.08045,0.14038-0.189078,0.293598-0.187645,0.470854,0.02236,2.76567,0.03004-0.166108,0.07573,1.85002l-1.80787,0.04803-0.04803-1.0764c-0.02822-0.632307-0.377947-1.42259,1.17-2.83l1.24-1.26c0.37-0.36,0.59-0.86,0.59-1.41,0-1.1-0.9-2-2-2s-2,0.9-2,2h-2c0-2.21,1.79-4,4-4s4,1.79,4,4c0,0.88-0.36,1.68-0.930005,2.25z"/>
            </svg>
        </i>
        <div class="photo">
        </div>
        <span>注册</span>
        <form id="form_register" name="form_register" method="post" action="{{ url('act_register') }}">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div id="u" class="form-group">
                <input id="user_name" spellcheck=false class="form-control" name="user_name" type="text" size="18" alt="login" required="">
                <span class="form-highlight"></span>
                <span class="form-bar"></span>
                <label for="user_name" class="float-label">用户名</label>
                <erroru>
                    用户名必填
                    <i>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                            <path d="M0 0h24v24h-24z" fill="none"/>
                            <path d="M1 21h22l-11-19-11 19zm12-3h-2v-2h2v2zm0-4h-2v-4h2v4z"/>
                        </svg>
                    </i>
                </erroru>
            </div>
            <div id="p" class="form-group">
                <input id="password" class="form-control" spellcheck=false name="password" type="password" size="18" alt="login" required="">
                <span class="form-highlight"></span>
                <span class="form-bar"></span>
                <label for="password" class="float-label">密码</label>
                <errorp>
                    密码必填
                    <i>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                            <path d="M0 0h24v24h-24z" fill="none"/>
                            <path d="M1 21h22l-11-19-11 19zm12-3h-2v-2h2v2zm0-4h-2v-4h2v4z"/>
                        </svg>
                    </i>
                </errorp>
            </div>
            <div id="pc" class="form-group">
                <input id="password_confirmation" class="form-control" spellcheck=false name="password_confirmation" type="password" size="18" alt="login" required="">
                <span class="form-highlight"></span>
                <span class="form-bar"></span>
                <label for="password_confirmation" class="float-label">确认密码</label>
                <errorp>
                    确认密码必填
                    <i>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                            <path d="M0 0h24v24h-24z" fill="none"/>
                            <path d="M1 21h22l-11-19-11 19zm12-3h-2v-2h2v2zm0-4h-2v-4h2v4z"/>
                        </svg>
                    </i>
                </errorp>
            </div>
            <div id="e" class="form-group">
                <input id="email" class="form-control" spellcheck=false name="email" type="text" size="18" alt="login" required="">
                <span class="form-highlight"></span>
                <span class="form-bar"></span>
                <label for="email" class="float-label">邮箱</label>
                <errorp>
                    邮箱必填
                    <i>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                            <path d="M0 0h24v24h-24z" fill="none"/>
                            <path d="M1 21h22l-11-19-11 19zm12-3h-2v-2h2v2zm0-4h-2v-4h2v4z"/>
                        </svg>
                    </i>
                </errorp>
            </div>
            <div class="form-group">
                <div style="text-align: center;">
                    <button id="submit" type="submit" ripple>提交</button>
                    <a href="{{ url('login') }}">登录？</a>
                </div>
            </div>
        </form>
        @if (count($errors) > 0)
            <div style="text-align: center;">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>

    <link rel="stylesheet" type="text/css" href="{{ URL::asset("css/font.css") }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset("css/special.css") }}" />
    <script type="text/javascript" src="{{ URL::asset("js/lib/jquery-3.1.1.js") }}"></script>
    <script type="text/javascript" src="{{ URL::asset("js/register.js") }}"></script>
</body>
@endsection