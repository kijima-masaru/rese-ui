<?php //予約機能用コントローラ

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shop;
use App\Models\Reserve;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{
    public function store(Request $request, Shop $shop)
    {
        $user = Auth::user();

        Reserve::create([
            'day' => $request->day,
            'time' => $request->time,
            'people' => $request->people,
            'user_id' => $user->id,
            'shop_id' => $shop->id,
        ]);

        return redirect()->route('reservation.done'); // 予約完了ページへリダイレクト
    }
}
