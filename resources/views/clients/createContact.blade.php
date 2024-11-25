@extends('layouts.app')

@section('title', 'Création de contact')

@section('content')
    <div class="overflow-x-auto">
        <div class="min-w-screen flex items-center justify-center font-sans overflow-hidden">
            <div class="w-full lg:w-9/10">
                <div class="bg-white shadow-md rounded my-6 p-6">


                    <h2 class="text-lg font-bold mb-4">Création de contact pour la societe {{ $client->CT_Num }}</h2>
                    <form action="{{ route('create.contact.post', ['id_client' => $client->CT_Num]) }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label for="nom" class="block text-sm font-medium text-gray-700">Nom</label>
                            <input type="text" name="nom" id="nom" placeholder="Joe" class="px-4 py-2 border rounded-md">
                        </div>

                        <div class="mb-4">
                            <label for="prenom" class="block text-sm font-medium text-gray-700">Prenom</label>
                            <input type="text" name="prenom" id="prenom" placeholder="Doe" class="px-4 py-2 border rounded-md">
                        </div>

                        <div class="mb-4">
                            <label for="fonction" class="block text-sm font-medium text-gray-700">Fonction</label>
                            <input type="text" name="fonction" id="fonction" placeholder="PDG" class="px-4 py-2 border rounded-md">
                        </div>

                        <div class="mb-4">
                            <label for="telephone" class="block text-sm font-medium text-gray-700">Téléphone</label>
                            <input type="text" name="telephone" id="telephone" placeholder="0500000000" class="px-4 py-2 border rounded-md">
                        </div>

                        <div class="mb-4">
                            <label for="portable" class="block text-sm font-medium text-gray-700">Portable</label>
                            <input type="text" name="portable" id="portable" placeholder="0600000000" class="px-4 py-2 border rounded-md">
                        </div>

                        <div class="mb-4">
                            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                            <input type="text" name="email" id="email" placeholder="joe.doe@isociel.fr" class="px-4 py-2 border rounded-md">
                        </div>

                        <div>
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Créé</button>
                            <a href="{{ route('clients.info', ['id' => $client->CT_Num]) }}" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Retour</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
