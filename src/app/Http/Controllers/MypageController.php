<?php //マイページ表示用コントローラ

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MypageController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $reserves = $user->reserves;

        return view('mypage', compact('reserves'));
    }
}
