@extends('layouts.app')

@section('title', 'Création de contact')
<style>
    /* Ajoutez cette classe pour limiter la hauteur du dropdown et permettre le défilement */
    .dropdown-scroll {
        max-height: 200px; /* Limite à environ 5 éléments (ajustez si nécessaire) */
        overflow-y: auto;
    }
</style>
@section('content')
    <div class="overflow-x-auto">
        <div class="min-w-screen flex items-center justify-center font-sans overflow-hidden">
            <div class="w-full lg:w-9/10">
                <div class="bg-white shadow-md rounded my-6 p-6">

                    <h2 class="text-lg font-bold mb-4">Création de nouveau contact</h2>
                    <form action="{{ route('ticket.create.contactnoid.post') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label for="client" class="block text-sm font-medium text-gray-700">Client</label>
                            <input type="text" name="client" id="client" placeholder="Isociel" class="px-4 py-2 border rounded-md">
                            <div id="dropdown" class="absolute bg-white border border-gray-300 mt-1 rounded shadow-lg hidden dropdown-scroll"></div>
                        </div>

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
                            <a href="{{ route('create') }}" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Retour</a>
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
