<?php //予約機能用コントローラ

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shop;
use App\Models\Reserve;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ReservationController extends Controller
{
    public function store(Request $request, Shop $shop)
    {
        $user = Auth::user();

        $dateTime = Carbon::createFromFormat('Y-m-d H:i', $request->day . ' ' . $request->time);

        Reserve::create([
            'day' => $request->day,
            'time' => $dateTime,
            'people' => $request->people,
            'user_id' => $user->id,
            'shop_id' => $shop->id,
            'status' => 'before', // 初期値を設定
        ]);

        return redirect()->route('reservation.done')->with([
            'reservation' => [
                'day' => $dateTime->format('Y-m-d'),
                'time' => $dateTime->format('H:i'),
                'people' => $request->people,
            ],
        ]);
         // 予約完了ページへリダイレクト
    }

    public function destroy(Reserve $reservation)
    {
        $reservation->delete();

        return redirect()->route('mypage')->with('success', '予約が削除されました。');
    }

}
