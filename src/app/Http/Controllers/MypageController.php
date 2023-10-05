<?php //マイページ表示用コントローラ

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Shop; // ログインユーザーのお気に入り情報取得
use App\Models\Reserve; // ログインユーザーの予約情報取得
use App\Models\Area;
use App\Models\Genre;

class MypageController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // "reviewed" ステータスの予約を表示しないように、whereNotInを使用して条件を追加します
        $reserves = Reserve::where('user_id', $user->id)
            ->whereNotIn('status', ['reviewed'])
            ->get(); // リレーションを使用して予約データを取得

        $favoriteShops = auth()->user()->favorites;

        // お気に入り店舗の詳細情報を取得
        $favoriteShopDetails = [];
        foreach ($favoriteShops as $favoriteShop) {
            $area = Area::where('shop_id', $favoriteShop->shop_id)->value('area');
            $genre = Genre::where('shop_id', $favoriteShop->shop_id)->value('genre');
            $favoriteShopDetails[] = [
                'shop' => $favoriteShop->shop, // ->shop を追加
                'area' => $area,
                'genre' => $genre,
            ];
        }

        return view('mypage', compact('reserves', 'favoriteShopDetails')); // 'favoriteShopDetails'をビューに渡す
    }
}