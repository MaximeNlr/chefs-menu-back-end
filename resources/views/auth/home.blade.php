@extends('layouts.app')

@section('content')
<div class="container">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">Mon espace personnel</div>

            <div class="card-body">
                <h1>Bienvenue dans votre espace personnel !</h1>
            </div>
        </div>
    </div>
</div>

<!-- Undefined variable $restaurant -->
<form method="POST" action="{{ route('element.store', $restaurant->id) }}">
    @csrf

    <div class="form-group">
        <label for="nom">Nom</label>
        <input type="text" name="nom" id="nom" class="form-control" required>
    </div>

    <div class="form-group">
        <label for="categorie">Catégorie</label>
        <select name="categorie" id="categorie" class="form-control" required>
            <option value="entree">Entrée</option>
            <option value="plats">Plat</option>
            <option value="desserts">Dessert</option>
            <option value="boissons">Boisson</option>
        </select>
    </div>
    <div class="form-group">
        <label for="prix_HT">Prix HT</label>
        <input type="number" name="prix_HT" id="prix_HT" class="form-control">
    </div>

    <div class="form-group">
        <label for="taux_TVA">Taux de TVA (%)</label>
        <input type="number" name="taux_TVA" id="taux_TVA" class="form-control">
    </div>

    <button type="submit" class="btn btn-primary">Ajouter</button>
</form>
@endsection