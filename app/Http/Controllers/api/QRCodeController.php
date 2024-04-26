<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class QRCodeController extends Controller
{
    public function generate()
    {
        $restaurantName = ;
        $menuLink = '/menu/' . $restaurantName;

        $qrCode = QrCode::size(200)->generate(url($menuLink));

        return view('qrcode.qrcode', ['qrCode' => $qrCode]);

    }
}