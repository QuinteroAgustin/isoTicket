@extends('layouts.app')

@section('title', 'Edition des type de forfait')

@section('content')
    <div class="overflow-x-auto">
        <div class="min-w-screen flex items-center justify-center font-sans overflow-hidden">
            <div class="w-full lg:w-9/10">
                <div class="bg-white shadow-md rounded my-6 overflow-x-auto">
                    <div class="flex justify-between px-6 py-3">
                        <h2 class="text-lg font-semibold text-gray-800">Liste des Type de forfait</h2>

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
                            @foreach ($typeForfaits as $typeForfait)
                            <tr class="border-b border-gray-200 hover:bg-gray-100">
                                <td class="py-3 px-6 text-left whitespace-nowrap">{{ $typeForfait->id_type }}</td>
                                <td class="py-3 px-6 text-left">{{ $typeForfait->libelle }}</td>
                                <td class="py-3 px-6 text-left">
                                    <!-- Bouton pour modifier la typeForfait -->
                                    <a href="{{ route('params.typeForfait.modifier', ['id' => $typeForfait->id_type]) }}" class="text-indigo-600 hover:text-indigo-900">Modifier</a>
                                    <!-- Formulaire pour supprimer la typeForfait -->
                                    <form action="{{ route('params.typeForfait.supprimer', ['id' => $typeForfait->id_type]) }}" method="POST" class="inline">
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
                    <h2 class="text-lg font-bold mb-4">Ajouter un nouveau type de Forfait</h2>
                    <form action="{{ route('params.typeForfait.add') }}" method="POST">
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
