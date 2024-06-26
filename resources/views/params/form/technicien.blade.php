@extends('layouts.app')

@section('title', 'Edition des Techniciens')

@section('content')
    <div class="overflow-x-auto">
        <div class="min-w-screen flex items-center justify-center font-sans overflow-hidden">
            <div class="w-full lg:w-9/10">
                <div class="bg-white shadow-md rounded my-6 overflow-x-auto overflow-y-auto max-h-[60vh]">
                    <div class="flex justify-between px-6 py-3">
                        <h2 class="text-lg font-semibold text-gray-800">Liste des Techniciens</h2>
                    </div>
                    <table class="min-w-full table-auto">
                        <thead>
                            <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                                <th class="py-3 px-6 text-left">ID</th>
                                <th class="py-3 px-6 text-left">Nom</th>
                                <th class="py-3 px-6 text-left">Prénom</th>
                                <th class="py-3 px-6 text-left">Email</th>
                                <th class="py-3 px-6 text-left">Role</th>
                                <th class="py-3 px-6 text-left">Service</th>
                                <th class="py-3 px-6 text-left">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600 text-sm font-light">
                            @foreach ($techniciens as $technicien)
                            <tr class="border-b border-gray-200 hover:bg-gray-100">
                                <td class="py-3 px-6 text-left whitespace-nowrap">{{ $technicien->id_technicien }}</td>
                                <td class="py-3 px-6 text-left">{{ $technicien->nom }}</td>
                                <td class="py-3 px-6 text-left">{{ $technicien->prenom }}</td>
                                <td class="py-3 px-6 text-left">{{ $technicien->email }}</td>
                                <td class="py-3 px-6 text-left">{{ $technicien->role->libelle }}</td>
                                <td class="py-3 px-6 text-left">{{ $technicien->service->libelle }}</td>
                                <td class="py-3 px-6 text-left">
                                    <!-- Bouton pour modifier la technicien -->
                                    <a href="{{ route('params.technicien.modifier', ['id' => $technicien->id_technicien]) }}" class="text-indigo-600 hover:text-indigo-900">Modifier</a>
                                    <!-- Formulaire pour supprimer la technicien -->
                                    <form action="{{ route('params.technicien.supprimer', ['id' => $technicien->id_technicien]) }}" method="POST" class="inline">
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
                    <h2 class="text-lg font-bold mb-4">Ajouter un nouveau technicien</h2>
                    <form action="{{ route('params.technicien.add') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label for="nom" class="block text-sm font-medium text-gray-700">Nom</label>
                            <input type="text" name="nom" placeholder="Doe" class="px-4 py-2 border rounded-md">
                        </div>
                        <div class="mb-4">
                            <label for="prenom" class="block text-sm font-medium text-gray-700">Prénom</label>
                            <input type="text" name="prenom" placeholder="John" class="px-4 py-2 border rounded-md">
                        </div>
                        <div class="mb-4">
                            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                            <input type="text" name="email" placeholder="john.doe@isociel.fr" class="px-4 py-2 border rounded-md">
                        </div>
                        <div class="mb-4">
                            <label for="id_role" class="block text-sm font-medium text-gray-700">Rôle</label>
                            <select name="id_role" class="px-4 py-2 border rounded-md">
                                @foreach ($roles as $role)
                                    <option value="{{ $role->id_role }}">{{ $role->libelle }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-4">
                            <label for="id_service" class="block text-sm font-medium text-gray-700">Service</label>
                            <select name="id_service" class="px-4 py-2 border rounded-md">
                                @foreach ($services as $service)
                                    <option value="{{ $service->id_service }}">{{ $service->libelle }}</option>
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
