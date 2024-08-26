@extends('layouts.app')

@section('title', 'Paramétrages du compte')

@section('content')
<div class="container">
    <h1 class="text-2xl font-semibold mb-4">Modifier votre profil</h1>

    <h3>Nom : {{ $user->nom }}</h3>
    <h3>Prénom : {{ $user->prenom }}</h3>
    <h3>Mail : {{ $user->email }}</h3>

    <form action="{{ route('profile.update') }}" method="POST">
        @csrf
        <div class="mb-4">
            <label for="password" class="block text-gray-700">Nouveau mot de passe (optionnel)</label>
            <input type="password" name="password" id="password" class="form-input mt-1 block w-full">
            @error('password')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <div class="mb-4">
            <label for="password_confirmation" class="block text-gray-700">Confirmer le mot de passe</label>
            <input type="password" name="password_confirmation" id="password_confirmation" class="form-input mt-1 block w-full">
        </div>

        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            Mettre à jour le profil
        </button>
    </form>
</div>
@endsection
