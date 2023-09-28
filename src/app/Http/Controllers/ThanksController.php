<?php //お支払い完了ページ表示用コントローラ

namespace App\Http\Controllers;

class ThanksController extends Controller
{
    public function index()
    {
        return view('thanks');
    }
}
