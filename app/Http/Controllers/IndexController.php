<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IndexController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        $data = [
            'user' => $user,
            'server_addr' => $_SERVER['SERVER_ADDR'],
            'app_url' => $_SERVER['APP_URL'],
        ];

        return view('index', $data);
    }
}
