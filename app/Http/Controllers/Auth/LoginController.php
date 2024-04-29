<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        // On récupére seulement dans la request : Email et Password
        $credentials = $request->only('email', 'password');

        // On authentifie l'utilisateur en utilisant les informations données ici : Email et Password
        if (Auth::attempt($credentials)) {
            // Authentification réussie
            return redirect()->intended('home'); // Rediriger vers la page souhaitée après la connexion
        }


        // Authentification échouée
        return redirect()->route('login')->with('error', 'Adresse email ou mot de passe incorrect.');
    }
}
