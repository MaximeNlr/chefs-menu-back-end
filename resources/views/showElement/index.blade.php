@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Liste des éléments du restaurant</h1>
        <ul>
            @foreach($elements as $element)
                <li>{{ $element->nom }}</li>
            @endforeach
        </ul>
    </div>
@endsection
