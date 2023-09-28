<?php //店舗一覧ページ・マイページのお気に入り機能用コントローラ

namespace App\Http\Controllers;

use App\Models\Shop;
use App\Models\Favorite;

class FavoritesController extends Controller
    {
    public function add(Shop $shop)
    {
        auth()->user()->favorites()->attach($shop->id);
        $favoriteShops = auth()->user()->favorites;
        return redirect()->route('mypage', ['favoriteShops' => $favoriteShops])->with('success', 'お気に入りに追加しました');
    }

    public function remove(Shop $shop)
    {
        auth()->user()->favorites()->detach($shop->id);
        $favoriteShops = auth()->user()->favorites;
        return redirect()->route('mypage', ['favoriteShops' => $favoriteShops])->with('success', 'お気に入りを解除しました');
    }
}

