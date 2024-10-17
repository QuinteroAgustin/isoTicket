<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Technicien;
use App\Mail\ResetPassword;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class PasswordResetController extends Controller
{
    // Afficher le formulaire de saisie de l'adresse e-mail
    public function showEmailForm()
    {
        return view('profile.PasswordReset');  // Vue pour l'email
    }

    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        // Vérifie si l'email existe dans la table techniciens
        $email = $request->input('email');
        $technicien = Technicien::where('email', $email)->first();
        if (!$technicien) {
            // Si l'email n'existe pas, retourne un message de succès pour éviter de donner trop d'informations
            return redirect()->back()->with('success', 'Un lien de réinitialisation a été envoyé à votre email si elle existe dans la base.');
        }
        // Génère un token aléatoire
        $token = Str::random(60);

        // Insère le token dans la table password_resets
        PasswordReset::create([
            'email' => $email,
            'token' => $token,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        // Envoie l'email avec le lien de réinitialisation (ajuste selon ta vue)
        $data = ['token' => $token];
        Mail::to($email)->send(new ResetPassword($data));

        // Retournez une réponse de succès
        return redirect()->back()->with('success', 'Un lien de réinitialisation a été envoyé à votre email si elle existe dans la base.');
    }

    // Afficher le formulaire de réinitialisation du mot de passe avec le token
    public function showResetForm($token)
    {
        return view('profile.PasswordResetForm', ['token' => $token]);  // Vue pour reset
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:8',
        ], [
            'email.required' => 'L\'adresse e-mail est requise.',
            'email.email' => 'Veuillez entrer une adresse e-mail valide.',
            'password.required' => 'Le mot de passe est requis.',
            'password.min' => 'Le mot de passe doit comporter au moins :min caractères.',
            'password.confirmed' => 'Les mots de passe ne correspondent pas. Veuillez réessayer.',
            'token.required' => 'Le token est requis.',
        ]);

        // Vérifie si le token existe, n'a pas été utilisé et s'il n'a pas expiré
        $passwordReset = PasswordReset::where('token', $request->input('token'))
            ->where('email', $request->input('email'))
            ->where('used', 0)
            ->first();

        if (!$passwordReset) {
            // Retournez une réponse de succès
            return redirect()->back()->with('error', 'Token invalide ou déjà utilisé.');
        }

        // Vérifie si le token n'a pas dépassé 15 minutes
        $createdAt = Carbon::parse($passwordReset->created_at);
        if ($createdAt->diffInMinutes(Carbon::now()) > 15) {
            return redirect()->back()->with('error', 'Le token a expiré.');
        }

        // Vérifie si l'utilisateur existe
        $technicien = Technicien::where('email', $request->input('email'))->first();
        if (!$technicien) {
            return redirect()->back()->with('error', 'Utilisateur non trouvé.');
        }

        // Met à jour le mot de passe du technicien
        $technicien->password = Hash::make($request->input('password'));
        $technicien->save();

        // Marque le token comme utilisé
        $passwordReset->used = 1;
        $passwordReset->save();

        return redirect()->route('login')->with('Success', 'Mot de passe réinitialisé avec succès.');
    }
}
