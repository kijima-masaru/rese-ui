<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MypageController;
use App\Http\Controllers\ShopsController;
use App\Http\Controllers\DetailController;
use App\Http\Controllers\DoneController;
use App\Http\Controllers\ThanksController;
use App\Http\Controllers\FavoritesController;

// ログインが必要なルートグループ
Route::middleware('auth')->group(function () {
    // 店舗一覧ページの表示
    Route::get('/', [ShopsController::class, 'index']);
    Route::get('/shops', 'ShopsController@index')->name('shops.index');
    Route::get('/shops/search', 'ShopsController@search')->name('shops.search');
    // 店舗詳細ページの表示
    Route::get('/detail/:shop_id', [DetailController::class, 'index']);
    // マイページの表示
    Route::get('/mypage', [MypageController::class, 'index']);
    // 予約完了ページの表示
    Route::get('/done', [DoneController::class, 'index']);
    // お気に入り追加/解除のルート追加
    Route::post('/favorites/{shop}', 'FavoritesController@add')->name('favorites.add');
    Route::delete('/favorites/{shop}', 'FavoritesController@remove')->name('favorites.remove');
});

// サンクスページの表示
Route::get('/thanks', [ThanksController::class, 'index']);



//開発環境
//ログインページ：http://localhost/login
//新規登録ページ：http://localhost/register
//データベース : http://localhost:8080