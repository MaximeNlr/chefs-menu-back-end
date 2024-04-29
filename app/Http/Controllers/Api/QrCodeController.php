<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class QrCodeController extends Controller
{
    public function generate(Request $request)
    {
       
        $menuLink = $request->input('menuLink');
        $tableNumber = $request->input('tableNumber');
        
       // Renvoie le lien du menu avec un / Numéro de la table
        $qrCodeContent = "$menuLink/$tableNumber";

     
        $qrCode = QrCode::size(200)->generate($qrCodeContent);

        return response($qrCode)->header('Content-type', 'image/png');
    }
}
