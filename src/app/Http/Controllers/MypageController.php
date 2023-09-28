<?php //マイページ表示用コントローラ

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Shop;
use App\Models\Reserve;
use App\Models\Area; // 追加
use App\Models\Genre; // 追加

class MypageController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $reserves = Reserve::where('user_id', $user->id)
            ->whereNotIn('status', ['reviewed'])
            ->get();

        // areasテーブルとgenresテーブルからデータを取得
        $favoriteShops = $user->favorites->load('area', 'genre');

        return view('mypage', compact('reserves', 'favoriteShops'));
    }
}
