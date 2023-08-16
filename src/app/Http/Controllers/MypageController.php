<?php //マイページ表示用コントローラ

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Shop; // お気に入り情報関連

class MypageController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $reserves = $user->reserves;
        $favoriteShops = auth()->user()->favorites;

        return view('mypage', compact('reserves', 'favoriteShops'));
    }
}
