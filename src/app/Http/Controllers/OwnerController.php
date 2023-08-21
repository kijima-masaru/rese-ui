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
        // 新しい店舗情報を作成して保存
        $shop = new Shop();
        $shop->name = $request->input('name');
        $shop->area = $request->input('area');
        $shop->genre = $request->input('genre');
        $shop->overview = $request->input('overview');
        $shop->img = $request->input('img');
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
        $shop->img = $request->input('img');
        $shop->save();

        return redirect()->route('owner.edit')->with('success', '店舗情報を更新しました！');
    }
}
