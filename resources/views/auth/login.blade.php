@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">Connexion</div>

        <div class="card-body">
            @if(session('error'))
            <div>
                {{ session('error') }}
            </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf
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
                <div class="col-md-8 offset-md-4">
                    <button type="submit">
                        Se connecter
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection