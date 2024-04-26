<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Api\Controller;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class QRCodeController extends Controller
{
    public function generate()
    {
        $restaurantName = 'le-cafe-de-la-place';
        $menuLink = '/menu/' . $restaurantName;

        $qrCode = QrCode::size(200)->generate(url($menuLink));

        return view('qrcode.qrcode', ['qrCode' => $qrCode]);

    }
}