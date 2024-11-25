@extends('layouts.app')

@section('title', 'Edition de contact')

@section('content')
    <div class="overflow-x-auto">
        <div class="min-w-screen flex items-center justify-center font-sans overflow-hidden">
            <div class="w-full lg:w-9/10">
                <div class="bg-white shadow-md rounded my-6 p-6">
                    <div class="flex justify-between mb-3">
                        <div class="flex items-center">
                            <div class="flex justify-center items-center">
                                <h2 class="text-lg font-bold mb-4">Modification du contact ({{ $contact->CT_Nom }} {{ $contact->CT_Prenom }}) n°{{ $contact->cbMarq }} societe {{ $contact->CT_Num }}</h2>
                            </div>
                        </div>
                    </div>

                    <form action="{{ route('edit.contact.post', ['id_contact' => $contact->cbMarq]) }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label for="nom" class="block text-sm font-medium text-gray-700">Nom</label>
                            <input type="text" name="nom" id="nom" value="{{ $contact->CT_Nom }}" class="px-4 py-2 border rounded-md">
                        </div>

                        <div class="mb-4">
                            <label for="prenom" class="block text-sm font-medium text-gray-700">Prenom</label>
                            <input type="text" name="prenom" id="prenom" value="{{ $contact->CT_Prenom }}" class="px-4 py-2 border rounded-md">
                        </div>

                        <div class="mb-4">
                            <label for="fonction" class="block text-sm font-medium text-gray-700">Fonction</label>
                            <input type="text" name="fonction" id="fonction" value="{{ $contact->CT_Fonction }}" class="px-4 py-2 border rounded-md">
                        </div>

                        <div class="mb-4">
                            <label for="telephone" class="block text-sm font-medium text-gray-700">Téléphone</label>
                            <input type="text" name="telephone" id="telephone" value="{{ $contact->CT_Telephone }}" class="px-4 py-2 border rounded-md">
                        </div>

                        <div class="mb-4">
                            <label for="portable" class="block text-sm font-medium text-gray-700">Portable</label>
                            <input type="text" name="portable" id="portable" value="{{ $contact->CT_TelPortable }}" class="px-4 py-2 border rounded-md">
                        </div>

                        <div class="mb-4">
                            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                            <input type="text" name="email" id="email" value="{{ $contact->CT_EMail }}" class="px-4 py-2 border rounded-md">
                        </div>

                        <div>
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Modifier</button>
                            <a href="{{ route('clients.info', ['id' => $contact->CT_Num]) }}" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Retour</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
