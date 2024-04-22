@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Ajouter un nouvel élément</h1>
    <form method="POST" action="{{ route('element.store', $restaurant->id) }}">
        @csrf

        <div class="form-group">
            <label for="nom">Nom</label>
            <input type="text" name="nom" id="nom" required>
        </div>

        <div class="form-group">
            <label for="categorie">Catégorie</label>
            <select name="categorie" id="categorie" required>
                <option value="entree">Entrée</option>
                <option value="plats">Plat</option>
                <option value="desserts">Dessert</option>
                <option value="boissons">Boisson</option>
            </select>
        </div>
        <div class="form-group">
            <label for="prix_HT">Prix HT</label>
            <input type="number" name="prix_HT" id="prix_HT">
        </div>

        <div class="form-group">
            <label for="taux_TVA">Taux de TVA (%)</label>
            <input type="number" name="taux_TVA" id="taux_TVA">
        </div>

        <button type="submit" class="btn btn-primary">Ajouter</button>
    </form>
    @if ($errors->any())
    @foreach ($errors->all() as $error)
    <div>{{ $error }}</div>
    @endforeach
    @endif
</div>
@endsection
