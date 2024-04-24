<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Restaurant;
use App\Models\Produit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class RestaurantController extends Controller
{

    /**
     * DEBUT DU CRUD
     */

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
        // Validation des données entrées par l'utilisateur
        $validator = Validator::make($request->all(), [
            'nom' => 'required|string|max:255',
            'adresse' => 'required|string|max:255',
            'horaires' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Si la validation échoue, renvoyer les erreurs de validation
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        // Créer un nouveau restaurant avec les données fournies par l'utilisateur
        $restaurant = new Restaurant($request->only(['nom', 'adresse', 'horaires']));

        // Sauvegarder le nouveau restaurant dans la base de données
        $restaurant->save();

        // Générer le lien pour le menu | slug = chaine de caractère pour URL en remplaçant les espaces par des " - "
        $menuLink = '/menu/' . Str::slug($restaurant->name);

        // Retourner une réponse JSON indiquant que le restaurant a été créé avec succès, ainsi que le lien du menu
        return response()->json(['message' => 'Restaurant créé avec succès.', 'restaurant' => $restaurant, 'menu_link' => $menuLink], 201);
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
     * FIN DU CRUD
     */

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

    /**
     * Store a newly created resource in storage.
     */
    public function storeElement(Request $request, string $restaurant_id)
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

        // Créer un nouvel élément (produit) avec les données fournies par l'utilisateur
        $element = new Produit([
            'nom' => $request->input('nom'), // Récupère le nom du produit depuis la requête
            'categorie' => $request->input('categorie'), // Récupère la catégorie du produit depuis la requête
            'prix_HT' => $request->input('prix_HT'), // Récupère le prix HT du produit depuis la requête
            'taux_TVA' => $request->input('taux_TVA'), // Récupère le taux de TVA du produit depuis la requête
            'prix_TTC' => $request->input('prix_HT') * (1 + $request->input('taux_TVA') / 100), // Calcule le prix TTC du produit en fonction du prix HT et du taux de TVA
        ]);

        // Sauvegarder le nouvel élément (produit) associé au restaurant
        $restaurant->produits()->save($element);

        // Retourner une réponse JSON indiquant que l'élément a été ajouté avec succès
        return response()->json(['message' => 'Élément ajouté avec succès.', 'element' => $element], 201);
    }


    public function showRestaurant($id)
    {
        $restaurant = Restaurant::find($id);
        if ($restaurant) {
            return view('showElement.create', ['restaurant' => $restaurant]);
        } else {
            // Gérer le cas où aucun restaurant n'est pas trouvé avec l'ID fourni
            return response()->json(['message' => 'Restaurant non trouvé'], 404);
        }
    }
}
