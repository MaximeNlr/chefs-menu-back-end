<?php

namespace App\Http\Controllers\api;

use App\Models\Restaurant;
use Illuminate\Http\Request;
use App\Models\Produit;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ProduitController extends Controller
{
    public function index($restaurant_id)
    {
        // Vérifie si l'utilisateur est connecté
        if (Auth::check()) {
            $restaurant = Restaurant::find($restaurant_id);

            // Récupère tous les produits associés au restaurant spécifié
            $produits = Produit::where('restaurant_id', $restaurant->id)->get();

            // Retourne la réponse JSON avec les produits
            return response()->json($produits);
        } else {
            // Retourne une réponse non autorisée si l'utilisateur n'est pas connecté
            return response()->json([], 401);
        }
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, string $restaurant_id)
    {
        // Validation des données entrées par l'utilisateur
        $validator = Validator::make($request->all(), [
            'nom' => 'required|string|max:255',
            'categorie' => 'required|string|in:entree,plats,desserts,boissons',
            'prix_HT' => 'required|numeric|min:0',
            'taux_TVA' => 'required|numeric|min:0',
        ]);

        // Si la validation échoue, renvoyer les erreurs de validation
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        // Trouver le restaurant associé à l'ID fourni
        $restaurant = Restaurant::find($restaurant_id);
        if (!$restaurant) {
            return response()->json(['message' => 'Restaurant non trouvé'], 404);
        }

        // Calculer le prix TTC
        $prix_HT = $request->input('prix_HT');
        $taux_TVA = $request->input('taux_TVA');
        $prix_TTC = $prix_HT * (1 + $taux_TVA / 100);

        // Créer un nouvel élément (produit) avec les données fournies par l'utilisateur
        $element = new Produit([
            'nom' => $request->input('nom'), // Récupère le nom du produit depuis la requête
            'categorie' => $request->input('categorie'), // Récupère la catégorie du produit depuis la requête
            'prix_HT' => $prix_HT,
            'taux_TVA' => $taux_TVA,
            'prix_TTC' => $prix_TTC, // Calcule le prix TTC du produit en fonction du prix HT et du taux de TVA
        ]);

        // Sauvegarder le nouvel élément (produit) associé au restaurant
        $restaurant->produits()->save($element);

        // Retourner une réponse JSON indiquant que l'élément a été ajouté avec succès
        return response()->json(['message' => 'Élément ajouté avec succès.', 'element' => $element], 201);
    }


    /**
     * Display the specified resource.
     */
    public function show(Restaurant $id)
    {
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Restaurant $id)
    {
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Restaurant $id)
    {
    }

    // PRODUITS 
    public function storeProduit(Request $request, string $restaurant_id)
    {
    }
}
