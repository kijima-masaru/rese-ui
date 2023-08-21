<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shop; // Shopモデルをインポート

class OwnerController extends Controller
{
    public function index()
    {
        return view('owner');
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
}
