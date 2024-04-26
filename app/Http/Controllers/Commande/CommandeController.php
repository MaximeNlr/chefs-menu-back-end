<?php

namespace App\Http\Controllers\Commande;

use App\Http\Controllers\api\Controller;
use App\Models\Commande;
use Illuminate\Http\Request;

class CommandeController extends Controller
{
    public function index()
    {
        // Récupérer toutes les commandes
        $commandes = Commande::all();
        return view('commandes.index', compact('commandes'));
    }

    public function show(Commande $commande)
    {
        // Afficher les détails de la commande avec le total
        $total = $commande->details->sum('prix_TTC');
        return view('commandes.show', compact('commande', 'total'));
    }

    public function completeCommande(Commande $commande)
    {
        // Marquer la commande comme terminée
        $commande->update(['statut' => 'terminée']);
        return redirect()->back()->with('success', 'Commande terminée');
    }

    public function printReceipt(Commande $commande)
    {
        // Générer et afficher le récapitulatif de la commande (addition)
        $total = $commande->details->sum('prix_TTC');
        return view('commandes.receipt', compact('commande', 'total'));
    }
}
