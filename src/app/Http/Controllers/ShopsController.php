<?php //店舗一覧ページ表示・検索用コントローラ

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shop;
use App\Models\Area;
use App\Models\Genre;

class ShopsController extends Controller
{
    public function index()
    {
        $shops = Shop::all(); // すべての店舗情報を取得

        // エリアとジャンルを取得
        $areaData = Area::whereIn('shop_id', $shops->pluck('id'))->get();
        $genreData = Genre::whereIn('shop_id', $shops->pluck('id'))->get();

        return view('shops', compact('shops', 'areaData', 'genreData')); // ビューにデータを渡す
    }

    // 店舗一覧ページの検索機能
    public function search(Request $request)
    {
        $area = $request->input('area');
        $genre = $request->input('genre');
        $name = $request->input('name');

        $query = Shop::query();

        if ($name) {
            $query->where('name', 'LIKE', "%$name%");
        }

        // エリアとジャンルの条件を指定
        if ($area) {
            $query->whereIn('id', function ($query) use ($area) {
                $query->select('shop_id')
                    ->from('areas')
                    ->where('area', $area);
            });
        }

        if ($genre) {
            $query->whereIn('id', function ($query) use ($genre) {
                $query->select('shop_id')
                    ->from('genres')
                    ->where('genre', $genre);
            });
        }

        $shops = $query->get();

        // エリアとジャンルを取得
        $areaData = Area::whereIn('shop_id', $shops->pluck('id'))->get();
        $genreData = Genre::whereIn('shop_id', $shops->pluck('id'))->get();

        return view('shops', compact('shops', 'areaData', 'genreData'));
    }
}
