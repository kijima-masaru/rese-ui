<?php //店舗一覧ページ表示・検索用コントローラ

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shop;

class ShopsController extends Controller
{
    public function index()
    {
        // shopsテーブルからすべての店舗情報を取得し、areasとgenresを関連付けて取得
        $shops = Shop::with('area', 'genre')->get();

        return view('shops', ['shops' => $shops]);
    }

    // 店舗一覧ページの検索機能
    public function search(Request $request)
    {
        $area = $request->input('area');
        $genre = $request->input('genre');
        $name = $request->input('name');

        $query = Shop::query()->with('area', 'genre'); // areasとgenresを事前に関連付けて取得

        if ($area) {
            $query->whereHas('area', function ($query) use ($area) {
                $query->where('area', $area);
            });
        }

        if ($genre) {
            $query->whereHas('genre', function ($query) use ($genre) {
                $query->where('genre', $genre);
            });
        }

        if ($name) {
            $query->where('name', 'LIKE', "%$name%");
        }

        $shops = $query->get();

        return view('shops', ['shops' => $shops]);
    }
}
