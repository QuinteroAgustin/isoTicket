<?php

namespace App\Http\Controllers;

use App\Models\Technicien;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function home()
    {
        //$technicien = Technicien::findorfail(Technicien::getTechId());
        return view('home.index');
    }

    public function notFound()
    {
        return view('error.404');
    }

    public function login()
    {
        return view('home.login');
    }

    public function loginPost(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Technicien::login($credentials['email'], $credentials['password'])) {
            // Rediriger l'utilisateur vers une autre vue après la connexion réussie
            return redirect()->route('home');
        } else {
            // Si les informations d'identification sont incorrectes, rediriger l'utilisateur vers la page de connexion avec un message d'erreur
            return redirect()->route('login')->with('error', 'Adresse e-mail ou mot de passe incorrect.');
        }
    }

    public function logoutPost(Request $request)
    {
        Technicien::logout();
        return redirect('/login');
    }
}
