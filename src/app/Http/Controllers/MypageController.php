<?php //マイページ表示用コントローラ

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Shop; // ログインユーザーのお気に入り情報取得
use App\Models\Reserve; // ログインユーザーの予約情報取得

class MypageController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // "reviewed" ステータスの予約を表示しないように、whereNotInを使用して条件を追加します
        $reserves = Reserve::where('user_id', $user->id)
            ->whereNotIn('status', ['reviewed'])
            ->with('shop.area', 'shop.genre') // エリア情報とジャンル情報をロード
            ->get(); // リレーションを使用して予約データを取得

            $favoriteShops = $user->favorites->load('area', 'genre'); // エリア情報とジャンル情報をロード

        return view('mypage', compact('reserves', 'favoriteShops'));
    }

}