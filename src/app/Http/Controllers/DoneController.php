<?php //予約完了ページ表示用コントローラ

namespace App\Http\Controllers;

class DoneController extends Controller
{
    public function index()
    {
        return view('done');
    }
}
