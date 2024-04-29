@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Liste des commandes</h1>
        <ul>
            @foreach($commandes as $commande)
                <li>
                    <a href="{{ route('commandes.show', $commande->id) }}">Commande {{ $commande->id }}</a> - Statut : {{ $commande->statut }}
                </li>
            @endforeach
        </ul>
    </div>
@endsection
