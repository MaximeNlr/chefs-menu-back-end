<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        // Valider les données du formulaire
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'string', 'min:5'],
        ]);

        // Hashage du mot de passe
        $mot_de_passe_hash = password_hash($request->password, PASSWORD_DEFAULT);

        // Créer un nouvel utilisateur
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $mot_de_passe_hash,
        ]);


        // Rediriger l'utilisateur vers la page de connexion après l'inscription
        return redirect()->route('login')->with('success', 'Veuillez vous connecter dès à présent');
    }
}
