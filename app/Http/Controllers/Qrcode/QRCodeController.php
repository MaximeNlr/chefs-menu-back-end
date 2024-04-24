<?php

namespace App\Http\Controllers\QRCode;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class QRCodeController extends Controller
{
    public function generate()
    {
        // Générer le lien pour le menu
        $restaurantName = 'le-cafe-de-la-place';
        $menuLink = '/menu/' . $restaurantName;

        // Générer le code QR pour le lien du menu
        $qrCode = QrCode::size(200)->generate(url($menuLink));

        // Afficher la vue avec le code QR
        return view('qrcode.qrcode', ['qrCode' => $qrCode]);

    }
}
