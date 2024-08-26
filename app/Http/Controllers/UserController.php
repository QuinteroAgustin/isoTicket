<?php

namespace App\Http\Controllers;

use App\Models\Technicien;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // Afficher le formulaire de modification du profil
    public function edit()
    {
        $user = Technicien::findOrFail(Technicien::getTechId());
        return view('profile.edit', compact('user'));
    }

    // Mettre à jour le profil de l'utilisateur
    public function update(Request $request)
    {
        $request->validate([
            'password' => 'nullable|string|min:8|confirmed',
        ], [
            'password.min' => 'Le mot de passe doit contenir au moins 8 caractères.',
            'confirmed' => 'Le mot de passe et sa confirmation doivent correspondre.',
        ]);

        $user = Technicien::findOrFail(Technicien::getTechId());

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('profile.edit')->with('success', 'Profil mis à jour avec succès.');
    }
}
