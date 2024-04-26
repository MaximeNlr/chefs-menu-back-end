<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Récapitulatif</title>
</head>
<body>
    <h1>Récapitulatif de la commande {{ $commande->id }}</h1>
    <ul>
        <li>Statut: {{ $commande->statut }}</li>
        <li>Date de création: {{ $commande->created_at }}</li>
        <li>Détails de la commande:
            <ul>
                @foreach($commande->details as $detail)
                    <li>{{ $detail->produit->nom }} - {{ $detail->prix_TTC }} €</li>
                @endforeach
            </ul>
        </li>
        <li>Total: {{ $total }} €</li>
    </ul>
</body>
</html>
