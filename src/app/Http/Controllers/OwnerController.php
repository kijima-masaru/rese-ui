<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Authファサードをインポート
use Illuminate\Support\Facades\Storage;
use App\Models\Shop; // Shopモデルをインポート

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
        // S3用
        //$imgPath = $request->file('img')->store('img', 's3');

        // 新しい店舗情報を作成して保存
        $shop = new Shop();
        $shop->name = $request->input('name');
        $shop->area = $request->input('area');
        $shop->genre = $request->input('genre');
        $shop->overview = $request->input('overview');

        // 画像のパスをデータベースに保存
        $shop->img = $imgPath;

        $shop->user_id = $request->input('user_id');
        $shop->save();

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
        $shop->area = $request->input('area');
        $shop->genre = $request->input('genre');
        $shop->overview = $request->input('overview');

        $shop->save();

        return redirect()->route('owner.edit')->with('success', '店舗情報を更新しました！');
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
        // S3用
        //$newImgPath = $request->file('img')->store('img', 's3');

        // 古い画像を削除
        if ($shop->img) {
            // ローカルストレージ用
            Storage::delete($shop->img);
            // S3用
            //Storage::disk('s3')->delete($shop->img);
        }

        // 画像のパスを更新
        $shop->img = $newImgPath;
        $shop->save();

        return redirect()->route('owner.edit', $id)->with('success', '店舗情報の画像を更新しました！');
    }
}