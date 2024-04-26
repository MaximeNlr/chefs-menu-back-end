<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class QrCodeController extends Controller
{
    public function generate(Request $request)
    {
       
        $menuLink = $request->input('menuLink');
        $tableNumber = $request->input('tableNumber');
        
       
        $qrCodeContent = "$menuLink/$tableNumber";

     
        $qrCode = QrCode::size(200)->generate($qrCodeContent);

       
        return response($qrCode)->header('Content-type', 'image/png');
    }
}
