@extends('layouts.app')

@section('title', 'Edition des forfaits')

@section('content')
<style>
    /* Ajoutez cette classe pour limiter la hauteur du dropdown et permettre le défilement */
    .dropdown-scroll {
        max-height: 200px; /* Limite à environ 5 éléments (ajustez si nécessaire) */
        overflow-y: auto;
    }
</style>
    <div class="overflow-x-auto">
        <div class="min-w-screen flex items-center justify-center font-sans overflow-hidden">
            <div class="w-full lg:w-9/10">
                <div class="bg-white shadow-md rounded my-6 overflow-x-auto overflow-y-auto max-h-[60vh]">
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
                                <th class="py-3 px-6 text-left">Service</th>
                                <th class="py-3 px-6 text-left">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600 text-sm font-light">
                            @foreach ($forfaits as $forfait)
                            @php
                                $colorBg = '';
                                if($forfait->restant() < 0){
                                    $colorBg = 'bg-red-200';
                                }
                            @endphp
                            <tr class="border-b border-gray-200 {{ $colorBg }} hover:bg-gray-100">
                                <td class="py-3 px-6 text-left whitespace-nowrap">{{ $forfait->id_forfait }}</td>
                                <td class="py-3 px-6 text-left">{{ $forfait->id_client }}</td>
                                <td class="py-3 px-6 text-left">{{ \Carbon\Carbon::parse($forfait->created_at)->format('d/m/Y') }}</td>
                                <td class="py-3 px-6 text-left">{{ \Carbon\Carbon::parse($forfait->valid_to)->format('d/m/Y') }}</td>
                                <td class="py-3 px-6 text-left">{{ $forfait->credit }}</td>
                                <td class="py-3 px-6 text-left">{{ $forfait->restantEnHeures() }}</td>
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
                            <label for="client" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Client</label>
                            <div class="flex">
                            <span class="inline-flex items-center px-3 text-sm text-gray-900 bg-gray-200 border rounded-e-0 border-gray-300 border-e-0 rounded-s-md dark:bg-gray-600 dark:text-gray-400 dark:border-gray-600">
                                <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10 0a10 10 0 1 0 10 10A10.011 10.011 0 0 0 10 0Zm0 5a3 3 0 1 1 0 6 3 3 0 0 1 0-6Zm0 13a8.949 8.949 0 0 1-4.951-1.488A3.987 3.987 0 0 1 9 13h2a3.987 3.987 0 0 1 3.951 3.512A8.949 8.949 0 0 1 10 18Z"/>
                                </svg>
                            </span>
                            <input type="text" id="client" name="client" class="rounded-none rounded-e-lg bg-gray-50 border text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm border-gray-300 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="isociel" autocomplete="off">
                            </div>
                            <div id="dropdown" class="absolute bg-white border border-gray-300 mt-1 rounded shadow-lg hidden dropdown-scroll"></div>
                        </div>
                        <div id="dropdown" class="absolute bg-white border border-gray-300 mt-1 rounded shadow-lg hidden dropdown-scroll"></div>
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

    <script>
        document.getElementById('client').addEventListener('input', function() {
            let search = this.value.trim();
            if (search.length > 0) {
                axios.get('{{ route("search.clients") }}', { params: { search: search } })
                    .then(response => {
                        let clients = response.data;
                        let dropdown = document.getElementById('dropdown');
                        dropdown.innerHTML = '';
                        if (clients.length > 0) {
                            clients.forEach(client => {
                                let div = document.createElement('div');
                                div.classList.add('p-2', 'cursor-pointer', 'hover:bg-gray-200');
                                div.textContent = `${client.CT_Num} - ${client.CT_Intitule}`;
                                div.addEventListener('click', function() {
                                    document.getElementById('client').value = client.CT_Num;
                                    dropdown.classList.add('hidden');
                                });
                                dropdown.appendChild(div);
                            });
                            dropdown.classList.remove('hidden');
                        } else {
                            dropdown.classList.add('hidden');
                        }
                    });
            } else {
                document.getElementById('dropdown').classList.add('hidden');
            }
        });

        document.addEventListener('click', function(event) {
            let dropdown = document.getElementById('dropdown');
            if (!dropdown.contains(event.target) && event.target.id !== 'client') {
                dropdown.classList.add('hidden');
            }
        });
    </script>
@endsection
