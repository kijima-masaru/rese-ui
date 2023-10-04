<?php //店舗一覧ページ表示・検索用コントローラ

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shop;
use App\Models\Area;
use App\Models\Genre;
use Illuminate\Support\Facades\DB;

class ShopsController extends Controller
{
    public function index()
    {
        $shops = Shop::all(); // すべての店舗情報を取得

        // エリアとジャンルを取得
        $areaData = Area::whereIn('shop_id', $shops->pluck('id'))->get();
        $genreData = Genre::whereIn('shop_id', $shops->pluck('id'))->get();

        // エリアとジャンル情報を店舗と対応させる
        $areaDataMap = [];
        $genreDataMap = [];

        foreach ($areaData as $area) {
            $areaDataMap[$area->shop_id] = $area;
        }

        foreach ($genreData as $genre) {
            $genreDataMap[$genre->shop_id] = $genre;
        }

        return view('shops', compact('shops', 'areaDataMap', 'genreDataMap')); // ビューにデータを渡す
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

        // エリアとジャンル情報を店舗と対応させる
        $areaDataMap = [];
        $genreDataMap = [];

        foreach ($areaData as $area) {
            $areaDataMap[$area->shop_id] = $area;
        }

        foreach ($genreData as $genre) {
            $genreDataMap[$genre->shop_id] = $genre;
        }

        return view('shops', compact('shops', 'areaDataMap', 'genreDataMap'));
    }

    // ランダムにソートするメソッド
    public function random()
    {
        $shops = Shop::inRandomOrder()->get();
        $shopIds = $shops->pluck('id');

        $areaData = Area::whereIn('shop_id', $shopIds)->get();
        $genreData = Genre::whereIn('shop_id', $shopIds)->get();

        // エリアとジャンル情報を店舗と対応させる
        $areaDataMap = [];
        $genreDataMap = [];

        foreach ($areaData as $area) {
            $areaDataMap[$area->shop_id] = $area;
        }

        foreach ($genreData as $genre) {
            $genreDataMap[$genre->shop_id] = $genre;
        }

        return view('shops', compact('shops', 'areaDataMap', 'genreDataMap'));
    }

    // 評価が高い順にソートするメソッド
    public function highRated()
    {
        $shops = Shop::select('shops.*')
            ->leftJoin('reviews', 'shops.id', '=', 'reviews.shop_id')
            ->groupBy('shops.id')
            ->orderByRaw('AVG(reviews.rating) DESC')
            ->get();

        $shopIds = $shops->pluck('id');
        $areaData = Area::whereIn('shop_id', $shopIds)->get();
        $genreData = Genre::whereIn('shop_id', $shopIds)->get();

        // エリアとジャンル情報を店舗と対応させる
        $areaDataMap = [];
        $genreDataMap = [];

        foreach ($areaData as $area) {
            $areaDataMap[$area->shop_id] = $area;
        }

        foreach ($genreData as $genre) {
            $genreDataMap[$genre->shop_id] = $genre;
        }

        return view('shops', compact('shops', 'areaDataMap', 'genreDataMap'));
    }

    // 評価が低い順にソートするメソッド
    public function lowRated()
    {
        $shops = Shop::select('shops.*')
            ->leftJoin('reviews', 'shops.id', '=', 'reviews.shop_id')
            ->groupBy('shops.id')
            ->orderByRaw('AVG(reviews.rating) ASC')
            ->get();

        $shopIds = $shops->pluck('id');
        $areaData = Area::whereIn('shop_id', $shopIds)->get();
        $genreData = Genre::whereIn('shop_id', $shopIds)->get();

        // エリアとジャンル情報を店舗と対応させる
        $areaDataMap = [];
        $genreDataMap = [];

        foreach ($areaData as $area) {
            $areaDataMap[$area->shop_id] = $area;
        }

        foreach ($genreData as $genre) {
            $genreDataMap[$genre->shop_id] = $genre;
        }

        return view('shops', compact('shops', 'areaDataMap', 'genreDataMap'));
    }
}