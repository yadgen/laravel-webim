<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginPost;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index(Request $request)
    {
        if (Auth::check()) {
            return redirect()->route('index');
        }

        $data = [];

        return view('login', $data);
    }

    public function act_login(LoginPost $request)
    {
        $remember = $request->has('remember') ? true : false;
        if (Auth::attempt(['user_name' => $request['user_name'], 'password' => $request['password']], $remember)) {
            return redirect()->route('index');
        } else {
            return redirect()->route('login');
        }
    }
}
