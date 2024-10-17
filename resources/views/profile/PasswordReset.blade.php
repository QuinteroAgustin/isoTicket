@extends('layouts.app_logout')

@section('title', 'Réinitialisation de votre mot de passe')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-100">
    <div class="max-w-md w-full bg-white p-8 rounded-lg shadow-lg">
        <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">Réinitialiser le mot de passe</h2>

        <form action="{{ route('password.email') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label for="email" class="block text-gray-700 font-medium mb-2">Adresse e-mail</label>
                <input type="email" id="email" name="email" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="Votre e-mail" required>
                @error('email')
                    <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-center mb-4">
                <button type="submit" class="w-full bg-indigo-600 text-white p-3 rounded-lg hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    Envoyer le lien de réinitialisation
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
