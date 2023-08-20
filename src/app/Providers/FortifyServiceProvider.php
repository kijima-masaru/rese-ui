<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use Laravel\Fortify\Fortify;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Notifications\VerifyEmail;
use Illuminate\Auth\Notifications\ResetPassword;
use Laravel\Fortify\Contracts\ResetPasswordViewResponse;
use Laravel\Fortify\Contracts\ResetsUserPasswords;
use Laravel\Fortify\Contracts\LoginResponse; //ログイン後のリダイレクト先をカスタマイズ

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register()
    {
        // ログイン後のリダイレクト先をusersテーブルのroleによってカスタマイズ
        $this->app->instance(LoginResponse::class, new class implements LoginResponse {
            public function toResponse($request)
            {
                if ($request->user()->role === 'admin') {
                    return redirect()->route('admin.index');
                } elseif ($request->user()->role === 'owner') {
                return redirect()->route('owner.index');
                } else {
                return redirect()->route('shops.index');
                }
            }
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        $this->app->make('router')->aliasMiddleware('verified', \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class);

        Fortify::createUsersUsing(CreateNewUser::class);

        Fortify::registerView(function () {
            return view('auth.register');
        });

        Fortify::verifyEmailView(function () {
            return view('auth.verify-email');
        });

        Fortify::loginView(function () {
            return view('auth.login');
        });

        //パスワード再設定メールの送信ページ
        Fortify::requestPasswordResetLinkView(function () {
            return view('auth.forgot-password');
        });

        //パスワード再設定フォームのページ
        Fortify::resetPasswordView(function ($request) {
            return view('auth.reset-password', ['request' => $request]);
        });

        //パスワード再設定の処理
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);

        RateLimiter::for('login', function (Request $request) {
            $email = (string) $request->email;

            return Limit::perMinute(10)->by($email . $request->ip());
        });

        Route::middleware('verified')->group(function () {
            // メール確認が必要なルートやルートグループ
        });

    }
}

//ログインページ：http://localhost/login
//新規登録ページ：http://localhost/register
//データベース : http://localhost:8080