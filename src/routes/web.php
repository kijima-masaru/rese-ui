<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\StampController;
use App\Http\Controllers\WorkController;
use App\Http\Controllers\BreakController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\VerificationController;

// ログインが必要なルートグループ
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/', [StampController::class, 'index']);
});



//開発環境
//ログインページ：http://localhost/login
//新規登録ページ：http://localhost/register
//データベース : http://localhost:8080