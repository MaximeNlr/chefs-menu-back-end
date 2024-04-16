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
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            // Authentification réussie
            return redirect()->intended('path'); // Rediriger vers la page souhaitée après la connexion
        }

        // Authentification échouée
        return redirect()->route('login')->with('error', 'Adresse email ou mot de passe incorrect.');
    }
}
