<?php //店舗詳細表示用コントローラ

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shop;
use App\Models\Area;
use App\Models\Genre;
use App\Models\Review;

class DetailController extends Controller
{
    public function index(Shop $shop)
    {
        // エリアとジャンルを取得
        $area = Area::where('shop_id', $shop->id)->value('area');
        $genre = Genre::where('shop_id', $shop->id)->value('genre');

        // 店舗に関連するレビュー情報を取得
        $reviews = Review::where('shop_id', $shop->id)->get();

        return view('detail_shop', compact('shop', 'area', 'genre', 'reviews'));
    }
}