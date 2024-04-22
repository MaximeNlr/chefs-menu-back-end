@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Détails de l'élément "{{ $element->nom }}"</h1>
        <ul>
            <li>Catégorie : {{ $element->categorie }}</li>
            <li>Prix HT : {{ $element->prix_HT }}</li>
            <li>Taux de TVA (%) : {{ $element->taux_TVA }}</li>
        </ul>
    </div>
@endsection
