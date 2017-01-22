<?php

namespace App\Http\Controllers;

use App\User;
use App\Http\Requests\RegisterPost;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    public function index(Request $request)
    {
        if (Auth::check()) {
            return redirect()->route('index');
        }

        $data = [];

        return view('register', $data);
    }

    public function act_register(RegisterPost $request)
    {
        $user = User::create([
            'user_name' => $request['user_name'],
            'email' => $request['email'],
            'password' => bcrypt($request['password']),
        ]);

        Auth::login($user);

        return redirect()->route('index');
    }
}
