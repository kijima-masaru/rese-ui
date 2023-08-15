<?php //店舗一覧ページ表示・検索用コントローラ

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shop;
use Illuminate\Support\Facades\Input;

class ShopsController extends Controller
{
    public function index()
    {
        $shops = Shop::all(); // すべての店舗情報を取得

        return view('shops', ['shops' => $shops]); // ビューにデータを渡す
    }

    // 店舗一覧ページの検索機能
    public function search(Request $request)
    {
        $area = $request->input('area');
        $genre = $request->input('genre');
        $name = $request->input('name');

        $query = Shop::query();

        if ($area) {
            $query->where('area', $area);
        }

        if ($genre) {
            $query->where('genre', $genre);
        }

        if ($name) {
            $query->where('name', 'LIKE', "%$name%");
        }

        $shops = $query->get();

        return view('shops', ['shops' => $shops]);
    }
}

