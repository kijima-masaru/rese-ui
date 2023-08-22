<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController; //管理者ページ表示用コントローラ
use App\Http\Controllers\OwnerController; //店舗代表者ページ表示用コントローラ
use App\Http\Controllers\ShopsController; //店舗一覧ページ表示・検索機能用コントローラ
use App\Http\Controllers\DetailController; //店舗詳細ページ表示用コントローラ
use App\Http\Controllers\ReservationController; //店舗詳細ページ予約機能用コントローラ
use App\Http\Controllers\EditController; //予約内容変更ページ表示・機能用コントローラ
use App\Http\Controllers\MypageController; //マイページ表示用コントローラ
use App\Http\Controllers\DoneController; //予約完了ページ表示用コントローラ
use App\Http\Controllers\FavoritesController; //お気に入り機能用コントローラ
use App\Http\Controllers\ThanksController; //サンクスページ表示用コントローラ
use App\Http\Controllers\VerificationController; //認証メール再送信用コントローラ


// ログインが必要なルートグループ
Route::middleware('auth', 'verified')->group(function () {
    // 管理者ページを表示するためのルート(管理者がログインするとリダイレクトされる)
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
    // 管理者ページでのユーザー情報の取得・表示するためのルート
    Route::get('/admin/users', [AdminController::class, 'userList'])->name('admin.userList');
    // 管理者ページでのユーザーのrole変更するためのルート
    Route::patch('/admin/update-role/{user}', [AdminController::class, 'updateRole'])->name('admin.updateRole');

    // 店舗代表者ページを表示するためのルート(店舗代表者がログインするとリダイレクトされる)
    Route::get('/owner', [OwnerController::class, 'index'])->name('owner.index');
    // 店舗情報の作成するためのルート
    Route::post('/owner/store', [OwnerController::class, 'store'])->name('owner.store');
    // 店舗情報の修正するためのルート
    Route::get('/owner/edit', [OwnerController::class, 'edit'])->name('owner.edit');
    // 店舗情報の更新するためのルート
    Route::put('/owner/update/{id}', [OwnerController::class, 'update'])->name('owner.update');


    // 店舗一覧ページの表示(利用者がログインするとリダイレクトされる)
    Route::get('/', [ShopsController::class, 'index'])->name('shops.index');
    // 店舗一覧ページの検索機能
    Route::get('/shops/search', [ShopsController::class, 'search'])->name('shops.search');

    // 店舗詳細ページの表示
    Route::get('/shops/{shop}', [DetailController::class, 'index'])->name('shop.detail');

    // 予約機能のルート
    Route::post('/reservations/{shop}', [ReservationController::class, 'store'])->name('reservations.store');
    Route::view('/reservation/done', 'done')->name('reservation.done');
    Route::delete('/reservations/{reservation}', [ReservationController::class, 'destroy'])->name('reservations.destroy');

    Route::get('/edit', [EditController::class, 'index'])->name('reservation.edit');
    Route::post('/update-reservation', [EditController::class, 'update'])->name('update_reservation');


    // マイページの表示
    Route::get('/mypage', [MypageController::class, 'index'])->name('mypage');
    // 予約完了ページの表示
    Route::get('/done', [DoneController::class, 'index']);
    // お気に入り追加/解除のルート追加
    Route::post('/favorites/{shop}', [FavoritesController::class, 'add'])->name('favorites.add');
    Route::delete('/favorites/{shop}', [FavoritesController::class, 'remove'])->name('favorites.remove');
});

// メール再送信のルーティング
Route::post('/email/verification-notification', [VerificationController::class, 'sendEmailVerificationNotification'])
    ->middleware(['auth', 'throttle:6,1'])
    ->name('verification.send');


//開発環境
//ログインページ:http://localhost/login
//新規登録ページ:http://localhost/register
//データベース:http://localhost:8080