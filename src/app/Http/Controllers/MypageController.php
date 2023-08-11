<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MypageController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            return view('mypage');
        } else {
            return redirect()->route('login'); // ログインしていない場合はログイン画面にリダイレクト
        }
    }
}
