<?php //店舗詳細表示用コントローラ

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shop;
use App\Models\Area;
use App\Models\Genre;
use App\Models\Review;

class DetailController extends Controller
{
    public function index(Shop $shop, Request $request)
    {
        // エリアとジャンルを取得
        $area = Area::where('shop_id', $shop->id)->value('area');
        $genre = Genre::where('shop_id', $shop->id)->value('genre');

        // 口コミのソートを適用
        $sort = $request->input('sort', 'default'); // デフォルトはソートなし

        $reviewsQuery = Review::where('shop_id', $shop->id);

        switch ($sort) {
            case 'random':
                $reviewsQuery->inRandomOrder();
                break;
            case 'high-rated':
                $reviewsQuery->orderBy('rating', 'desc');
                break;
            case 'low-rated':
                $reviewsQuery->orderBy('rating', 'asc');
                break;
            default:
                // デフォルトはソートなし
                break;
        }

        $reviews = $reviewsQuery->get();

        return view('detail_shop', compact('shop', 'area', 'genre', 'reviews', 'sort'));
    }
}
