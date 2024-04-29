<?php

namespace App\Http\Controllers\Api;

use App\Models\Produit;
use App\Models\Commande;
use App\Models\Detail;
use Illuminate\Http\Request;

class CommandeController extends Controller
{
    public function store(Request $request)
{
    $data = $request->validate([
        'restaurant_id' => 'required|exists:restaurants,id',
        'table_id' => 'required|exists:tables,id',
        'produits.*.produit_id' => 'required|exists:produits,id',
        'produits.*.quantite' => 'required|integer|min:0',
    ]);

    $restaurantId = $data['restaurant_id'];
    $tableId = $data['table_id'];
    $produits = $data['produits'];

    $prixTotal = 0;

    $commande = new Commande();
    $commande->restaurant_id = $restaurantId;
    $commande->table_id = $tableId;
    $commande->save();

    foreach ($produits as $produit) {
        $produitId = $produit['produit_id'];
        $quantite = $produit['quantite'];
        $produit = Produit::findOrFail($produitId);
        $prixTotal += $produit->prix_TTC * $quantite;

        $detail = new Detail([
            'produit_id' => $produitId,
            'quantite' => $quantite,
            'prix' => $produit->prix_TTC,
        ]);
        $commande->details()->save($detail);
    }

    $commande->prix_total = $prixTotal;
    $commande->save();

    return response()->json(['message' => 'Commande créée avec succès'], 201);
}

}
