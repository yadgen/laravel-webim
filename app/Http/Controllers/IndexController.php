<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IndexController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $user->user_avatar = user_avatar();

        $data = [
            'user' => $user,
            'server_addr' => $_SERVER['SERVER_ADDR'],
        ];

        return view('index', $data);
    }
}
