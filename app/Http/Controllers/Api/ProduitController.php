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
        if (Auth::check()) {
            $restaurant = Restaurant::find($restaurant_id);

            $produits = Produit::where('restaurant_id', $restaurant->id)->get();

            return response()->json($produits);
        } else {
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

        $prix_HT = $request->input('prix_HT');
        $taux_TVA = $request->input('taux_TVA');
        $prix_TTC = $prix_HT * (1 + $taux_TVA / 100);

        $element = new Produit([
            'nom' => $request->input('nom'), 
            'categorie' => $request->input('categorie'), 
            'prix_HT' => $prix_HT,
            'taux_TVA' => $taux_TVA,
            'prix_TTC' => $prix_TTC, 
        ]);

        $restaurant->produits()->save($element);

        return response()->json(['message' => 'Élément ajouté avec succès.', 'element' => $element], 201);
    }

    public function destroy($id)
    {
        $produit = Produit::find($id);
        if ($produit) {
            $produit->delete();
            return response()->json(['message' => 'Produit supprimé avec succès']);
        } else {
            return response()->json(['message' => 'Produit non trouvé'], 404);
        }
    }

}
