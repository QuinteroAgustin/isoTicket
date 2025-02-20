@extends('layouts.app')
@section('title', 'Liste des clients')
@section('content')
<div class="container">
    <h1 class="text-2xl font-semibold">Recherche de Client</h1>
    <!-- Formulaire de filtrage -->
    <form action="{{ route('clients.index') }}" method="GET" class="mb-4">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
            <!-- Filtre Code client CT_Num -->
            <div>
                <label for="CT_Num" class="block text-gray-700">Numéro du Client</label>
                <input type="text" name="CT_Num" id="CT_Num" class="form-input mt-1 block w-full" value="{{ request('CT_Num') }}">
            </div>

            <!-- Filtre par CT_Intitulé -->
            <div>
                <label for="CT_Intitule" class="block text-gray-700">Intitulé du Client</label>
                <input type="text" name="CT_Intitule" id="CT_Intitule" class="form-input mt-1 block w-full" value="{{ request('CT_Intitule') }}">
            </div>

            <!-- Filtre par Telephone -->
            <div>
                <label for="CT_Telephone" class="block text-gray-700">Téléphone du Client</label>
                <input type="text" name="CT_Telephone" id="CT_Telephone" class="form-input mt-1 block w-full" value="{{ request('CT_Telephone') }}">
            </div>

            <!-- Filtre par ville -->
            <div>
                <label for="CT_Ville" class="block text-gray-700">Ville</label>
                <input type="text" name="CT_Ville" id="CT_Ville" class="form-input mt-1 block w-full" value="{{ request('CT_Ville') }}">
            </div>

            <!-- Filtre par adresse -->
            <div>
                <label for="CT_Adresse" class="block text-gray-700">Adresse</label>
                <input type="text" name="CT_Adresse" id="CT_Adresse" class="form-input mt-1 block w-full" value="{{ request('CT_Adresse') }}">
            </div>

            <!-- Filtre par Code postal -->
            <div>
                <label for="CT_CodePostal" class="block text-gray-700">Code postal</label>
                <input type="text" name="CT_CodePostal" id="CT_CodePostal" class="form-input mt-1 block w-full" value="{{ request('CT_CodePostal') }}">
            </div>

            <!-- Filtre par Siret -->
            <div>
                <label for="CT_Siret" class="block text-gray-700">Siret</label>
                <input type="text" name="CT_Siret" id="CT_Siret" class="form-input mt-1 block w-full" value="{{ request('CT_Siret') }}">
            </div>
        </div>

        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            Rechercher
        </button>
    </form>

    <!-- clients/client_table.blade.php -->
    <div id="clientTable">
        <!-- Affichage des tickets filtrés -->
        @if(isset($clients) && $clients->count() > 0)
        <div class="overflow-x-auto">
            <div class="min-w-screen flex justify-center font-sans">
                <div class="w-full lg:w-9/10">
                    <div class="bg-white shadow-md rounded my-6 overflow-x-auto">
                        <table class="min-w-full table-auto">
                            <thead>
                                <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                                    <th class="py-3 px-6 text-left">ID</th>
                                    <th class="py-3 px-6 text-left">Intitulé</th>
                                    <th class="py-3 px-6 text-center">Téléphone</th>
                                    <th class="py-3 px-6 text-center">Adresse</th>
                                    <th class="py-3 px-6 text-center">Ville</th>
                                    <th class="py-3 px-6 text-center">Code postal</th>
                                    <th class="py-3 px-6 text-center">Siret</th>
                                    <th class="py-3 px-6 text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-600 text-sm font-light">
                                @foreach ($clients as $client)
                                    <tr class="border-b border-gray-200 hover:bg-gray-100">
                                        <td class="py-3 px-6 text-left whitespace-nowrap">{{ $client->CT_Num }}</td>
                                        <td class="py-3 px-6 text-left">{{ $client->CT_Intitule }}</td>
                                        <td class="py-3 px-6 text-center">{{ $client->CT_Telephone }}</td>
                                        <td class="py-3 px-6 text-center">{{ $client->CT_Adresse }}</td>
                                        <td class="py-3 px-6 text-center">{{ $client->CT_Ville }}</td>
                                        <td class="py-3 px-6 text-center">{{ $client->CT_CodePostal }}</td>
                                        <td class="py-3 px-6 text-center">{{ $client->CT_Siret }}</td>
                                        <td class="py-3 px-6 text-center">
                                            <a href="{{ route('clients.info', ['id' => $client->CT_Num]) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                                Infos
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @else
        <p class="text-center text-gray-500">Aucun client trouvé pour les critères de recherche.</p>
    @endif

    </div>


    {{-- Pagination --}}
    <div class="d-flex justify-content-center my-4">
        {{ $clients->appends(request()->input())->links() }}
    </div>
</div>
@endsection
