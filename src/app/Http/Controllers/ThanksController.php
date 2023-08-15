<?php //サンクスページ表示用コントローラ

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ThanksController extends Controller
{
    public function index()
    {
        return view('thanks');
    }
}
