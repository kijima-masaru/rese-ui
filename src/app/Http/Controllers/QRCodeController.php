<?php // QRコード用コントローラ

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reserve;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class QRCodeController extends Controller
{
    public function generateQRCode($reserveId)
{
    $reserve = Reserve::findOrFail($reserveId);
    $user = $reserve->user;
    $shop = $reserve->shop;

    $qrData = "Reservation ID: $reserveId\n";
    $qrData .= "Time: {$reserve->time}\n";
    $qrData .= "People: {$reserve->people}\n";
    $qrData .= "User Name: {$user->name}\n";
    $qrData .= "User Email: {$user->email}\n";
    $qrData .= "Shop Name: {$shop->name}\n";

    return response(QrCode::generate($qrData))
        ->header('Content-Type', 'image/png');
}
}

