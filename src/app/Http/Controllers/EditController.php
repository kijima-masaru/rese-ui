<?php //予約内容変更ページ表示用・機能用コントローラ

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reserve; // ログインしているユーザーの予約情報を取得

class EditController extends Controller
{
    public function index()
    {
        // ログインしているユーザーに関連する予約情報を取得する例
        $user = auth()->user(); // ログインユーザーを取得
        $reservations = Reserve::where('user_id', $user->id)->get(); // 予約情報を取得

        return view('reservation_edit', ['reservations' => $reservations]);
    }

    public function update(Request $request)
    {
        $reservationId = $request->input('reservation_id');
        $day = $request->input('day');
        $time = $request->input('time');
        $people = $request->input('people');

        $reservation = Reserve::find($reservationId);
        if (!$reservation) {
            // Handle error, reservation not found
        }

        $reservation->day = $day;
        $reservation->time = $day . ' ' . $time . ':00';
        $reservation->people = $people;
        $reservation->save();

        return redirect()->back()->with('success', '予約情報が更新されました。');
    }
}
