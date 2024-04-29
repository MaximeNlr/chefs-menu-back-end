<?php

namespace App\Http\Controllers\api;

use App\Models\Table;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class TableController extends Controller
{
    public function store(Request $request, $restaurant_id)
    {
       if (Auth::check()) {
        $user_id = Auth::id();

        $validated = $request->validate([
            'numero_table' => 'required|numeric'
        ]);

        $table = Table::create([
            'numero_table' => $validated['numero_table'],
            'user_id' => $user_id,
            'restaurant_id' => $restaurant_id
        ]);

        $table->save();

        return response()->json(['message' => 'Table crée avec succés.', 'table' => $table], 201);
       } else {
        return response()->json(['message' => 'Utilisateur non authentifié.'], 401);
       }
    }

    public function show($restaurant_id)
{
    $restaurant = Restaurant::with('produits')->findOrFail($restaurant_id);

    return response()->json($restaurant, 200);
}
}
