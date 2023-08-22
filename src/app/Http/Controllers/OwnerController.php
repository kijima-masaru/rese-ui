<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Authファサードをインポート
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
        $imgPath = $request->file('img')->store('img');

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
        // 例えば、成功時には店舗一覧ページにリダイレクトすることができます
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

        // 新しい画像がアップロードされた場合、古い画像を削除して新しい画像を保存
        if ($request->hasFile('new_img')) {
            $newImgPath = $request->file('new_img')->store('public/img');
            // ここで古い画像を削除する処理を追加する必要があります

            // 新しい画像のパスを保存
            $shop->img = $newImgPath;
        }

        $shop->save();

        return redirect()->route('owner.edit')->with('success', '店舗情報を更新しました！');
    }
}