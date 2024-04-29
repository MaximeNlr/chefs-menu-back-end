<?php

namespace App\Http\Controllers;
use App\Http\Controllers\api\Controller;

use App\Models\Restaurant;
use App\Models\Produit;
use Illuminate\Http\Request;

class CarteController extends Controller
{
    public function index($restaurant_id) 
    {
        $restaurant = Restaurant::find($restaurant_id);
        $produits = Produit::where('restaurant_id', $restaurant->id)->get();

        return response()->json($produits);
    }
}
