<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Authファサードをインポート
use Illuminate\Support\Facades\Storage;
use App\Models\Shop; // Shopモデルをインポート
use App\Models\Area; // Areaモデルをインポート
use App\Models\Genre; // Genreモデルをインポート

class Admin_ShopController extends Controller
{
    public function index()
    {
        // ログインユーザーが作成した店舗情報を取得
        $shops = Shop::where('user_id', Auth::id())->get();

        return view('admin_shop', compact('shops'));
    }

    public function store(Request $request)
    {
        // 画像をアップロード
        // ローカルストレージ用
        $imgPath = $request->file('img')->store('img');

        // 新しい店舗情報を作成して保存
        $shop = new Shop();
        $shop->name = $request->input('name');
        $shop->overview = $request->input('overview');

        // 画像のパスをデータベースに保存
        $shop->img = $imgPath;

        $shop->user_id = $request->input('user_id');
        $shop->save();

        // areasテーブルに保存
        $area = new Area();
        $area->area = $request->input('area');
        $area->shop_id = $shop->id;
        $area->save();

        // genresテーブルに保存
        $genre = new Genre();
        $genre->genre = $request->input('genre');
        $genre->shop_id = $shop->id;
        $genre->save();

        // リダイレクトまたは適切な応答を返す
        return redirect()->route('admin.shop.index')->with('success', '店舗情報を作成しました！');
    }
}
