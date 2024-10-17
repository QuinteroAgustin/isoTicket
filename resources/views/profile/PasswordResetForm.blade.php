@extends('layouts.app_logout')

@section('title', 'Réinitialisation de votre mot de passe')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-100">
    <div class="max-w-md w-full bg-white p-8 rounded-lg shadow-lg">
        <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">Réinitialiser le mot de passe</h2>

        <!-- Formulaire de réinitialisation de mot de passe -->
        <form action="{{ route('password.update') }}" method="POST">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">

            <!-- Champ pour l'email -->
            <div class="mb-4">
                <label for="email" class="block text-gray-700 font-medium mb-2">Adresse e-mail</label>
                <input type="email" id="email" name="email" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="Votre e-mail" required>
                @error('email')
                    <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                @enderror
            </div>

            <!-- Champ pour le nouveau mot de passe -->
            <div class="mb-4">
                <label for="password" class="block text-gray-700 font-medium mb-2">Nouveau mot de passe</label>
                <input type="password" id="password" name="password" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="Votre nouveau mot de passe" required>
                @error('password')
                    <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                @enderror
            </div>

            <!-- Champ pour la confirmation du mot de passe -->
            <div class="mb-4">
                <label for="password_confirmation" class="block text-gray-700 font-medium mb-2">Confirmez le mot de passe</label>
                <input type="password" id="password_confirmation" name="password_confirmation" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="Confirmez votre mot de passe" required>
                @error('password_confirmation')
                    <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                @enderror
            </div>

            <!-- Bouton de soumission -->
            <div class="flex justify-center mb-4">
                <button type="submit" class="w-full bg-indigo-600 text-white p-3 rounded-lg hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    Réinitialiser le mot de passe
                </button>
            </div>

            <!-- Lien de retour à la page de connexion -->
            <div class="text-center">
                <a href="{{ route('login') }}" class="text-indigo-600 hover:underline">Retour à la connexion</a>
            </div>
        </form>
    </div>
</div>
@endsection
