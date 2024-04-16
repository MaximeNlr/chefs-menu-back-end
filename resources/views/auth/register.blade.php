@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Inscription</h1>

    <div class="form-group row">
        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div>
                <label for="name">Nom</label>

                <div class="col-md-6">
                    <input id="name" type="text" name="name" value="{{ old('name') }}">

                    @error('name')
                    <span class="invalid-feedback">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <label for="email">Adresse Email</label>

                <div class="col-md-6">
                    <input id="email" type="email" name="email" value="{{ old('email') }}">

                    @error('email')
                    <span class="invalid-feedback">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <label for="password">Mot de passe</label>

                <div class="col-md-6">
                    <input id="password" type="password" name="password">

                    @error('password')
                    <span class="invalid-feedback">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
            <div class="col-md-6 offset-md-5">
                <button type="submit">
                    S'inscrire
                </button>
            </div>
        </form>
    </div>
</div>
@endsection