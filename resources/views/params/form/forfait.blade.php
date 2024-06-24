@extends('layouts.app')

@section('title', 'Edition des forfaits')

@section('content')
    <div class="overflow-x-auto">
        <div class="min-w-screen flex items-center justify-center font-sans overflow-hidden">
            <div class="w-full lg:w-9/10">
                <div class="bg-white shadow-md rounded my-6 overflow-x-auto">
                    <div class="flex justify-between px-6 py-3">
                        <h2 class="text-lg font-semibold text-gray-800">Liste des forfaits</h2>

                    </div>
                    <table class="min-w-full table-auto">
                        <thead>
                            <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                                <th class="py-3 px-6 text-left">Code forfait</th>
                                <th class="py-3 px-6 text-left">Code client</th>
                                <th class="py-3 px-6 text-left">Date de création</th>
                                <th class="py-3 px-6 text-left">Date de validité</th>
                                <th class="py-3 px-6 text-left">Quantité</th>
                                <th class="py-3 px-6 text-left">Restant</th>
                                <th class="py-3 px-6 text-left">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600 text-sm font-light">
                            @foreach ($forfaits as $forfait)
                            <tr class="border-b border-gray-200 hover:bg-gray-100">
                                <td class="py-3 px-6 text-left whitespace-nowrap">{{ $forfait->id_forfait }}</td>
                                <td class="py-3 px-6 text-left">CLIENT A</td>
                                <td class="py-3 px-6 text-left">{{ \Carbon\Carbon::parse($forfait->created_at)->format('d/m/Y') }}</td>
                                <td class="py-3 px-6 text-left">{{ \Carbon\Carbon::parse($forfait->valid_to)->format('d/m/Y') }}</td>
                                <td class="py-3 px-6 text-left">{{ $forfait->credit }}</td>
                                <td class="py-3 px-6 text-left">{{ $forfait->type->libelle }}</td>
                                <td class="py-3 px-6 text-left">
                                    <!-- Bouton pour modifier la priorite -->
                                    <a href="{{ route('params.forfait.modifier', ['id' => $forfait->id_forfait]) }}" class="text-indigo-600 hover:text-indigo-900">Modifier</a>
                                    <!-- Formulaire pour supprimer la priorite -->
                                    <form action="{{ route('params.forfait.supprimer', ['id' => $forfait->id_forfait]) }}" method="POST" class="inline">
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
                    <h2 class="text-lg font-bold mb-4">Ajouter un nouveau forfait</h2>
                    <form action="{{ route('params.forfait.add') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="id_client">Code Client :</label>
                            <input type="text" name="id_client" placeholder="Code client (CT_Num)" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="created_at">Date de création :</label>
                            <input type="date" name="created_at" id="created_at" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="valid_to">Date de validité :</label>
                            <input type="date" name="valid_to" id="valid_to" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="credit">Crédit :</label>
                            <input type="number" name="credit" id="credit" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="type_id">Type :</label>
                            <select name="type_id" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                @foreach ($types as $type)
                                    <option value="{{ $type->id_type }}">{{ $type->libelle }}</option>
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
