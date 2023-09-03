<?php //QRコード読み取りページ表示用コントローラ

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Owner_QRController extends Controller
{
    public function index()
    {
        return view('owner_qrcode');
    }
}
