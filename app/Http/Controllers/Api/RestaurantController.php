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
        $user_id = auth()->id();
        $restaurants = Restaurant::where('user_id', $user_id)->get();
        return response()->json($restaurants);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user_id = 1;
        
        $validated = $request -> validate([
            'nom' => 'required|string|max:255',
            'adresse' => 'required|string|max:255',
            'horaires_ouverture' => 'required|string|max:255',
            'image_illustration' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ]);

        $restaurant = new Restaurant($request->only(['nom', 'adresse', 'horaires_ouverture']));
        $restaurant->user_id = $user_id;
        if ($request->hasFile('image_illustration')) {
            $path = $request->file('image_illustration')->store('public/restaurants');
            $restaurant->image_illustration = str_replace('public/', 'storage/', $path);
        }

        $restaurant->save();
        
        return response()->json(['message' => 'Restaurant créé avec succès.', 'restaurant' => $restaurant], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Restaurant $restaurant)
{
    if ($restaurant) {
        return response()->json($restaurant);
    } else {
        return response()->json(['message' => 'Restaurant non trouvé'], 404);
    }
}

    /**
     * Update the specified resource in storage.
     */
public function update(Request $request, Restaurant $restaurant)
{
    // Récupérer le restaurant spécifique par son ID
    $restaurant = Restaurant::findOrFail($restaurant->id);

    // Mettre à jour les champs spécifiés
    $restaurant->nom = $request->input('nom', $restaurant->nom);
    $restaurant->adresse = $request->input('adresse', $restaurant->adresse);
    $restaurant->horaires_ouverture = $request->input('horaires_ouverture', $restaurant->horaires_ouverture);

    // Vérifier s'il y a une nouvelle image dans la requête
    if ($request->hasFile('image_illustration')) {
        $path = $request->file('image_illustration')->store('public/restaurants');
        $restaurant->image_illustration = str_replace('public/', 'storage/', $path);
    }

    // Sauvegarder les changements
    $restaurant->save();

    // Retourner une réponse JSON avec un message de succès et les données du restaurant mis à jour
    return response()->json(['message' => 'Restaurant mis à jour avec succès.', 'restaurant' => $restaurant], 200);
}


    /**
     * Remove the specified resource from storage.
     */
public function destroy(Restaurant $restaurant)
{
    try {
        // Supprimer le restaurant spécifique
        $restaurant = Restaurant::findOrFail($restaurant->id);
        $restaurant->delete();

        // Retourner une réponse JSON avec un message de succès
        return response()->json(['message' => 'Restaurant supprimé avec succès']);
    } catch (\Exception $e) {
        // En cas d'erreur, retourner une réponse JSON avec un message d'erreur
        return response()->json(['message' => 'Erreur lors de la suppression du restaurant'], 500);
    }
}
}