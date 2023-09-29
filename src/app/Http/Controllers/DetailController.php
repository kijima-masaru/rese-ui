<?php //店舗詳細表示用コントローラ

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shop;
use App\Models\Area;
use App\Models\Genre;

class DetailController extends Controller
{
    public function index(Shop $shop)
    {
        // エリアとジャンルを取得
        $area = Area::where('shop_id', $shop->id)->value('area');
        $genre = Genre::where('shop_id', $shop->id)->value('genre');

        return view('detail_shop', compact('shop', 'area', 'genre'));
    }
}