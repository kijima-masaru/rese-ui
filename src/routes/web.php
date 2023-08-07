<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// メール再送信のルーティング
Route::post('/email/verification-notification', [VerificationController::class, 'sendEmailVerificationNotification'])
    ->middleware(['auth', 'throttle:6,1'])
    ->name('verification.send');


//開発環境
//ログインページ：http://localhost/login
//新規登録ページ：http://localhost/register
//データベース : http://localhost:8080
