@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Détails de la commande "{{ $commande->id }}"</h1>
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
        <!-- Si le statut de la commande est différent de "terminée", le contenu à l'intérieur de cette structure conditionnelle sera affiché-->
        @if($commande->statut !== 'terminée')
            <form method="POST" action="{{ route('commandes.complete', $commande->id) }}">
                @csrf
                <button type="submit">Marquer comme terminée</button>
            </form>
        @endif
    </div>
@endsection
