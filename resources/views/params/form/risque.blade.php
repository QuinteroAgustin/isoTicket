@extends('layouts.app')

@section('title', 'Edition des risques')

@section('content')
    <div class="overflow-x-auto">
        <div class="min-w-screen flex items-center justify-center font-sans overflow-hidden">
            <div class="w-full lg:w-9/10">
                <div class="bg-white shadow-md rounded my-6 overflow-x-auto">
                    <div class="flex justify-between px-6 py-3">
                        <h2 class="text-lg font-semibold text-gray-800">Liste des risques</h2>

                    </div>
                    <table class="min-w-full table-auto">
                        <thead>
                            <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                                <th class="py-3 px-6 text-left">ID</th>
                                <th class="py-3 px-6 text-left">Libelle</th>
                                <th class="py-3 px-6 text-left">Icon</th>
                                <th class="py-3 px-6 text-left">Fond</th>
                                <th class="py-3 px-6 text-left">Impact</th>
                                <th class="py-3 px-6 text-left">Priorite</th>
                                <th class="py-3 px-6 text-left">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600 text-sm font-light">
                            @foreach ($risques as $risque)
                            <tr class="border-b border-gray-200 hover:bg-gray-100">
                                <td class="py-3 px-6 text-left whitespace-nowrap">{{ $risque->id_risque }}</td>
                                <td class="py-3 px-6 text-left">{{ $risque->libelle }}</td>
                                <td class="py-3 px-6 text-left"><svg class="w-6 h-3 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">{!! $risque->icon !!}</svg></td>
                                <td class="py-3 px-6 text-left">{{ $risque->fond }}</td>
                                <td class="py-3 px-6 text-left">{{ $risque->impact->libelle }}</td>
                                <td class="py-3 px-6 text-left">{{ $risque->priorite->libelle }}</td>
                                <td class="py-3 px-6 text-left">
                                    <!-- Bouton pour modifier la priorite -->
                                    <a href="{{ route('params.risque.modifier', ['id' => $risque->id_risque]) }}" class="text-indigo-600 hover:text-indigo-900">Modifier</a>
                                    <!-- Formulaire pour supprimer la priorite -->
                                    <form action="{{ route('params.risque.supprimer', ['id' => $risque->id_risque]) }}" method="POST" class="inline">
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
                    <h2 class="text-lg font-bold mb-4">Ajouter un nouveau risque</h2>
                    <form action="{{ route('params.risque.add') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label for="libelle" class="block text-sm font-medium text-gray-700">Libellé</label>
                            <input type="text" name="libelle" placeholder="Libellé" class="px-4 py-2 border rounded-md">
                        </div>
                        <div class="mb-4">
                            <label for="icon" class="block text-sm font-medium text-gray-700">Icon</label>
                            <input type="text" name="icon" placeholder="Icon" class="px-4 py-2 border rounded-md">
                        </div>
                        <div class="mb-4">
                            <label for="fond" class="block text-sm font-medium text-gray-700">Fond</label>
                            <input type="text" name="fond" placeholder="bg-grey-600" class="px-4 py-2 border rounded-md">
                        </div>
                        <div class="mb-4">
                            <label for="impact_id" class="block text-sm font-medium text-gray-700">Impact</label>
                            <select name="impact_id" class="px-4 py-2 border rounded-md">
                                @foreach ($impacts as $impact)
                                    <option value="{{ $impact->id_impact }}">{{ $impact->libelle }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-4">
                            <label for="priorite_id" class="block text-sm font-medium text-gray-700">Priorité</label>
                            <select name="priorite_id" class="px-4 py-2 border rounded-md">
                                @foreach ($priorites as $priorite)
                                    <option value="{{ $priorite->id_priorite }}">{{ $priorite->libelle }}</option>
                                @endforeach
                            </select>
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
