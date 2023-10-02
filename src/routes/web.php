<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController; // 管理者ページ用コントローラ
use App\Http\Controllers\Admin_ReviewController; // 管理者レビュー閲覧ページ用コントローラ
use App\Http\Controllers\Admin_ShopController; // 管理者店舗情報作成ページ用コントローラ
use App\Http\Controllers\OwnerController; // 店舗代表者ページ用コントローラ
use App\Http\Controllers\Owner_ReserveController; // 店舗予約確認ページ用コントローラ
use App\Http\Controllers\Owner_QRController; // QRコード読み込みページ用のコントローラ
use App\Http\Controllers\ShowController; // 個人予約情報ページ用コントローラ
use App\Http\Controllers\ShopsController; // 店舗一覧ページ表示・検索機能用コントローラ
use App\Http\Controllers\DetailController; // 店舗詳細ページ表示用コントローラ
use App\Http\Controllers\ReservationController; // 店舗詳細ページ予約機能用コントローラ
use App\Http\Controllers\EditController; // 予約内容変更ページ表示・機能用コントローラ
use App\Http\Controllers\MypageController; // マイページ表示用コントローラ
use App\Http\Controllers\DoneController; // 予約完了ページ表示用コントローラ
use App\Http\Controllers\FavoritesController; // お気に入り機能用コントローラ
use App\Http\Controllers\ReviewController; // レビュー機能用コントローラ
use App\Http\Controllers\VerificationController; // 認証メール再送信用コントローラ
use App\Http\Controllers\StripeController; // stripe決済機能用コントローラ
use App\Http\Controllers\ThanksController; // お支払い完了ページ用コントローラ

// ログインが必要なルートグループ
Route::middleware('auth', 'verified')->group(function () {

    // 管理者ページ用ルート

    Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
    // 管理者ページでのユーザー情報の取得・表示するためのルート
    Route::get('/admin/users', [AdminController::class, 'userList'])->name('admin.userList');
    // 管理者ページでのユーザーのrole変更するためのルート
    Route::patch('/admin/update-role/{user}', [AdminController::class, 'updateRole'])->name('admin.updateRole');
    // 管理者ページでのユーザー検索機能のルート
    Route::get('/admin/search', [AdminController::class, 'searchUsers'])->name('admin.searchUsers');
    // 管理者口コミ一覧ページ表示のルート
    Route::get('/admin/reviews', [Admin_ReviewController::class, 'index'])->name('admin.reviews.index');
    // 管理者口コミ一覧ページの口コミ検索機能のルート
    Route::get('/admin/reviews/search', [Admin_ReviewController::class, 'search'])->name('admin.reviews.search');
    // 管理者口コミ一覧ページの口コミ削除機能のルート
    Route::delete('/admin/reviews/{review}', [Admin_ReviewController::class, 'destroy'])->name('admin.reviews.destroy');
    // 管理者店舗情報作成ページを表示するためのルート
    Route::get('/admin/shop', [Admin_ShopController::class, 'index'])->name('admin.shop.index');
    // 店舗情報の作成するためのルート
    Route::post('/admin/store', [Admin_ShopController::class, 'store'])->name('admin.shop.store');
    // CSVファイルで店舗情報の作成するためのルート
    Route::post('/admin/store/import', [Admin_ShopController::class, 'import'])->name('admin.import');

    // 店舗代表者ページ用ルート

    // 店舗代表者ページを表示するためのルート(店舗代表者がログインするとリダイレクトされる)
    Route::get('/owner', [OwnerController::class, 'index'])->name('owner.index');
    // 店舗情報の作成するためのルート
    Route::post('/owner/store', [OwnerController::class, 'store'])->name('owner.store');
    // 店舗情報の修正するためのルート
    Route::get('/owner/edit', [OwnerController::class, 'edit'])->name('owner.edit');
    // 店舗情報の更新するためのルート
    Route::put('/owner/update/{id}', [OwnerController::class, 'update'])->name('owner.update');
    // 店舗情報の画像を修正するためのルート
    Route::put('/owner/edit-image/{id}', [OwnerController::class, 'editImage'])->name('owner.edit-image');
    // 店舗情報の画像を更新するためのルート
    Route::put('/owner/update-image/{id}', [OwnerController::class, 'updateImage'])->name('owner.update-image');
    // 店舗予約確認ページを表示するためのルート
    Route::get('/owner_reserve', [Owner_ReserveController::class, 'index'])->name('owner.reserve');
    // 店舗予約確認ページの予約状況更新ボタンのルート
    Route::put('/update-status/{id}', [Owner_ReserveController::class, 'updateStatus'])->name('update.status');
    // 店舗予約確認ページのお知らせメール送信ルート
    Route::post('/send-notification-email/{id}', [Owner_ReserveController::class, 'sendNotificationEmail'])->name('send.notification.email');
    // 店舗予約確認ページのQRコード読み込み機能用ルート
    Route::get('/owner/qrcode', [Owner_QRController::class, 'index'])->name('owner.qrcode');
    // 個人予約情報ページの表示
    Route::get('/reservations/{reserve}', [ShowController::class, 'show'])->name('reservation.show');

    // 一般利用者ページ用ルート

    // 店舗一覧ページの表示(利用者がログインするとリダイレクトされる)
    Route::get('/', [ShopsController::class, 'index'])->name('shops.index');
    // 店舗一覧ページの検索機能
    Route::get('/shops/search', [ShopsController::class, 'search'])->name('shops.search');
    // ランダムにソート
    Route::get('/shops/random', [ShopsController::class, 'random'])->name('shops.random');
    // 評価が高い順にソート
    Route::get('/shops/high-rated', [ShopsController::class, 'highRated'])->name('shops.high-rated');
    // 評価が低い順にソート
    Route::get('/shops/low-rated', [ShopsController::class, 'lowRated'])->name('shops.low-rated');

    // 店舗詳細ページの表示
    Route::get('/shops/{shop}', [DetailController::class, 'index'])->name('shop.detail');

    // 予約機能のルート
    Route::post('/reservations/{shop}', [ReservationController::class, 'store'])->name('reservations.store');
    Route::delete('/reservations/{reservation}', [ReservationController::class, 'destroy'])->name('reservations.destroy');
    Route::view('/reservation/done', 'done')->name('reservation.done');

    Route::get('/edit', [EditController::class, 'index'])->name('reservation.edit');
    Route::post('/update-reservation', [EditController::class, 'update'])->name('update_reservation');

    // マイページの表示
    Route::get('/mypage', [MypageController::class, 'index'])->name('mypage');
    // 予約完了ページの表示
    Route::get('/done', [DoneController::class, 'index']);
    // お気に入り追加/解除のルート追加
    Route::post('/favorites/{shop}', [FavoritesController::class, 'add'])->name('favorites.add');
    Route::delete('/favorites/{shop}', [FavoritesController::class, 'remove'])->name('favorites.remove');
    // レビューのフォーム表示
    Route::get('/review/{shop}', [ReviewController::class, 'create'])->name('review.create');
    // レビューの保存
    Route::post('/review/{shop}', [ReviewController::class, 'store'])->name('review.store');
    // レビューの削除
    Route::delete('/review/{shop}/{review}', [ReviewController::class, 'destroy'])->name('review.destroy');
    // stripeでの決済機能のルート
    Route::get('/payment', [StripeController::class, 'index'])->name('user_stripe.index');
    Route::post('/pay', [StripeController::class, 'pay']);
    Route::get('/thanks', [ThanksController::class, 'index'])->name('thanks');
});

// メール再送信のルーティング
Route::post('/email/verification-notification', [VerificationController::class, 'sendEmailVerificationNotification'])
    ->middleware(['auth', 'throttle:6,1'])
    ->name('verification.send');


//開発環境
//ログインページ:http://localhost/login
//新規登録ページ:http://localhost/register
//データベース:http://localhost:8080