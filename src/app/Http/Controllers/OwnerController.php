<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Authファサードをインポート
use Illuminate\Support\Facades\Storage;
use App\Models\Shop; // Shopモデルをインポート
use App\Models\Area; // Areaモデルをインポート
use App\Models\Genre; // Genreモデルをインポート

class OwnerController extends Controller
{
    public function index()
    {
        // ログインユーザーが作成した店舗情報を取得
        $shops = Shop::where('user_id', Auth::id())->get();

        return view('owner', compact('shops'));
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
        return redirect()->route('owner.index')->with('success', '店舗情報を作成しました！');
    }

    public function edit()
    {
        // ログインユーザーが作成した店舗情報を取得
        $shops = Shop::where('user_id', Auth::id())->get();

        return view('owner', compact('shops'));
    }

    public function update(Request $request, $id)
    {
        // 対象の店舗情報を取得
        $shop = Shop::findOrFail($id);

        // ユーザーIDが一致することを確認
        if ($shop->user_id !== Auth::id()) {
            return abort(403, 'You are not authorized to edit this shop.');
        }

        // フォームデータを店舗情報に適用して保存
        $shop->name = $request->input('name');
        $shop->overview = $request->input('overview');

        $shop->save();

        // 関連するエリアを更新
        $area = Area::where('shop_id', $shop->id)->firstOrFail();
        $area->area = $request->input('area');
        $area->save();

        // 関連するジャンルを更新
        $genre = Genre::where('shop_id', $shop->id)->firstOrFail();
        $genre->genre = $request->input('genre');
        $genre->save();

        return redirect()->route('owner.edit', $id)->with('success', '店舗情報を更新しました！');
    }

    public function editImage($id)
    {
        // 対象の店舗情報を取得
        $shop = Shop::findOrFail($id);

        // ユーザーIDが一致することを確認
        if ($shop->user_id !== Auth::id()) {
            return abort(403, 'You are not authorized to edit this shop.');
        }

        return view('owner.edit-image', compact('shop'));
    }

    public function updateImage(Request $request, $id)
    {
        // 対象の店舗情報を取得
        $shop = Shop::findOrFail($id);

        // ユーザーIDが一致することを確認
        if ($shop->user_id !== Auth::id()) {
            return abort(403, 'You are not authorized to edit this shop.');
        }

        // 新しい画像をアップロード
        // ローカルストレージ用
        $newImgPath = $request->file('img')->store('img');

        // 古い画像を削除
        if ($shop->img) {
            // ローカルストレージ用
            Storage::delete($shop->img);
        }

        // 画像のパスを更新
        $shop->img = $newImgPath;
        $shop->save();

        return redirect()->route('owner.edit', $id)->with('success', '店舗情報の画像を更新しました！');
    }
}
