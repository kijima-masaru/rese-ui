<?php //店舗詳細表示用コントローラ

namespace App\Http\Controllers;

use App\Models\Shop;

class DetailController extends Controller
{
    public function index(Shop $shop)
    {
        // Shopモデルのリレーションを使ってエリアとジャンル情報を取得
        $shop->load('area', 'genre');

        return view('detail_shop', compact('shop'));
    }
}