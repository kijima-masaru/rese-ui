<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ShopsController; //店舗一覧ページ表示・検索機能用コントローラ
use App\Http\Controllers\DetailController; //店舗詳細ページ表示用コントローラ
use App\Http\Controllers\ReservationController; //店舗詳細ページ予約機能用コントローラ
use App\Http\Controllers\MypageController; //マイページ表示用コントローラ
use App\Http\Controllers\DoneController; //予約完了ページ表示用コントローラ
use App\Http\Controllers\FavoritesController; //お気に入り機能用コントローラ
use App\Http\Controllers\ThanksController; //サンクスページ表示用コントローラ


// ログインが必要なルートグループ
Route::middleware('auth')->group(function () {
    // 店舗一覧ページの表示
    Route::get('/', [ShopsController::class, 'index']);
    Route::get('/shops', [ShopsController::class, 'index'])->name('shops.index');
    Route::get('/shops/search', [ShopsController::class, 'search'])->name('shops.search');
    // 店舗詳細ページの表示
    Route::get('/shops/{shop}', [DetailController::class, 'index'])->name('shop.detail');
    // 予約機能のルート
    Route::post('/reservations/{shop}', [ReservationController::class, 'store'])->name('reservations.store');
    Route::view('/reservation/done', 'done')->name('reservation.done');
    // マイページの表示
    Route::get('/mypage', [MypageController::class, 'index']);
    // 予約完了ページの表示
    Route::get('/done', [DoneController::class, 'index']);
    // お気に入り追加/解除のルート追加
    Route::post('/favorites/{shop}', [FavoritesController::class, 'add'])->name('favorites.add');
    Route::delete('/favorites/{shop}', [FavoritesController::class, 'remove'])->name('favorites.remove');
});

// サンクスページの表示
Route::get('/thanks', [ThanksController::class, 'index']);



//開発環境
//ログインページ：http://localhost/login
//新規登録ページ：http://localhost/register
//データベース : http://localhost:8080