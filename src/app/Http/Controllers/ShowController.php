<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reserve;

class ShowController extends Controller
{
    public function show(Reserve $reserve)
    {
        // 予約情報の詳細を取得し、ビューに渡す
        return view('reservation.show', compact('reserve'));
    }
}
