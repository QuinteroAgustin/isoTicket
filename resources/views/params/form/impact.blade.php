@extends('layouts.app')

@section('title', 'Edition des impacts')

@section('content')
    <div class="overflow-x-auto">
        <div class="min-w-screen flex items-center justify-center font-sans overflow-hidden">
            <div class="w-full lg:w-9/10">
                <div class="bg-white shadow-md rounded my-6 overflow-x-auto overflow-y-auto max-h-[60vh]">
                    <div class="flex justify-between px-6 py-3">
                        <h2 class="text-lg font-semibold text-gray-800">Liste des Impacts</h2>

                    </div>
                    <table class="min-w-full table-auto">
                        <thead>
                            <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                                <th class="py-3 px-6 text-left">ID</th>
                                <th class="py-3 px-6 text-left">Libelle</th>
                                <th class="py-3 px-6 text-left">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600 text-sm font-light">
                            @foreach ($impacts as $impact)
                            <tr class="border-b border-gray-200 hover:bg-gray-100">
                                <td class="py-3 px-6 text-left whitespace-nowrap">{{ $impact->id_impact }}</td>
                                <td class="py-3 px-6 text-left">{{ $impact->libelle }}</td>
                                <td class="py-3 px-6 text-left">
                                    <!-- Bouton pour modifier la priorite -->
                                    <a href="{{ route('params.impact.modifier', ['id' => $impact->id_impact]) }}" class="text-indigo-600 hover:text-indigo-900">Modifier</a>
                                    <!-- Formulaire pour supprimer la priorite -->
                                    <form action="{{ route('params.impact.supprimer', ['id' => $impact->id_impact]) }}" method="POST" class="inline">
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
                    <h2 class="text-lg font-bold mb-4">Ajouter une nouvelle impact</h2>
                    <form action="{{ route('params.impact.add') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label for="libelle" class="block text-sm font-medium text-gray-700">Libellé</label>
                            <input type="text" name="libelle" placeholder="Libellé" class="px-4 py-2 border rounded-md">
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
