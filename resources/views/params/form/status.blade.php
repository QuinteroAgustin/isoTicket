@extends('layouts.app')

@section('title', 'Edition des status')

@section('content')
    <div class="overflow-x-auto">
        <div class="min-w-screen flex items-center justify-center font-sans overflow-hidden">
            <div class="w-full lg:w-9/10">
                <div class="bg-white shadow-md rounded my-6 overflow-x-auto overflow-y-auto max-h-[60vh]">
                    <div class="flex justify-between px-6 py-3">
                        <h2 class="text-lg font-semibold text-gray-800">Liste des Status</h2>

                    </div>
                    <table class="min-w-full table-auto">
                        <thead>
                            <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                                <th class="py-3 px-6 text-left">ID</th>
                                <th class="py-3 px-6 text-left">Libelle</th>
                                <th class="py-3 px-6 text-left">Ordre de tri</th>
                                <th class="py-3 px-6 text-left">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600 text-sm font-light">
                            @foreach ($statuses as $status)
                            <tr class="border-b border-gray-200 hover:bg-gray-100">
                                <td class="py-3 px-6 text-left whitespace-nowrap">{{ $status->id_statut }}</td>
                                <td class="py-3 px-6 text-left">{{ $status->libelle }}</td>
                                <td class="py-3 px-6 text-left">{{ $status->ordre_tri }}</td>
                                <td class="py-3 px-6 text-left">
                                    <!-- Bouton pour modifier le status -->
                                    <a href="{{ route('params.status.modifier', ['id' => $status->id_statut]) }}" class="text-indigo-600 hover:text-indigo-900">Modifier</a>
                                    <!-- Formulaire pour supprimer le status -->
                                    <form action="{{ route('params.status.supprimer', ['id' => $status->id_statut]) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900 ml-2">Supprimer</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="bg-white shadow-md rounded my-6 p-6">
                    <h2 class="text-lg font-bold mb-4">Ajouter un nouveau statut</h2>
                    <form action="{{ route('params.status.add') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label for="libelle" class="block text-sm font-medium text-gray-700">Libellé</label>
                            <input type="text" name="libelle" placeholder="Libellé" class="px-4 py-2 border rounded-md">
                        </div>
                        <div class="mb-4">
                            <label for="ordre_tri" class="block text-sm font-medium text-gray-700">Ordre de tri</label>
                            <input type="text" name="ordre_tri" placeholder="100" class="px-4 py-2 border rounded-md">
                        </div>
                        <div>
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Ajouter</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
