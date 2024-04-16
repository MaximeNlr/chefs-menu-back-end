<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RestaurantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // récupérer et retourner tous les restaurants:
        $restaurants = Restaurant::all();
        return response()->json($restaurants);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nom' => 'required|string|max:255',
            'adresse' => 'required|string|max:255',
            'horaires' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $restaurant = new Restaurant($request->only(['nom', 'adresse', 'horaires']));
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('public/restaurants');
            $restaurant->image = $path;
        }
        $restaurant->save();

        return response()->json(['message' => 'Restaurant créé avec succès.', 'restaurant' => $restaurant], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // récupérer un restaurant spécifique par ID
        $restaurant = Restaurant::find($id);
        if ($restaurant) {
            return response()->json($restaurant);
        } else {
            return response()->json(['message' => 'Restaurant non trouvé'], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // mettre à jour un restaurant spécifique
        $validator = Validator::make($request->all(), [
            'nom' => 'sometimes|required|string|max:255',    // 'sometimes' signifie que la validation suivante ne sera effectuée que si 'nom' est présent dans la requête.
            'adresse' => 'sometimes|required|string|max:255',
            'horaires' => 'sometimes|required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $restaurant = Restaurant::find($id);
        if (!$restaurant) {
            return response()->json(['message' => 'Restaurant non trouvé'], 404);
        }

        $restaurant->update($request->only(['nom', 'adresse', 'horaires']));

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('public/restaurants');
            $restaurant->image = $path;
        }

        $restaurant->save();
        return response()->json(['message' => 'Restaurant mis à jour avec succès.', 'restaurant' => $restaurant], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // supprimer un restaurant spécifique
        $restaurant = Restaurant::find($id);
        if ($restaurant) {
            $restaurant->delete();
            return response()->json(['message' => 'Restaurant supprimé avec succès']);
        } else {
            return response()->json(['message' => 'Restaurant non trouvé'], 404);
        }
    }
}
