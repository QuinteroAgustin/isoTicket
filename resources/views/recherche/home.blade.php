@extends('layouts.app')

@section('title', 'Recherche ticket')

@section('content')
<style>
    /* Ajoutez cette classe pour limiter la hauteur du dropdown et permettre le défilement */
    .dropdown-scroll {
        max-height: 200px; /* Limite à environ 5 éléments (ajustez si nécessaire) */
        overflow-y: auto;
    }
</style>
    <h1 class="text-2xl font-semibold">Recherche de ticket</h1>
    <!-- Formulaire de filtrage -->
    <form action="{{ route('recherche') }}" method="GET" class="mb-4">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
            <!-- Filtre par numéro de ticket -->
            <div>
                <label for="ticket_id" class="block text-gray-700">Numéro du Ticket</label>
                <input type="text" name="ticket_id" id="ticket_id" class="form-input mt-1 block w-full" value="{{ request('ticket_id') }}">
            </div>

            <!-- Filtre par nom du client -->
            <div>
                <label for="client_name" class="block text-gray-700">Nom du Client</label>
                <input type="text" name="client_name" id="client_name" class="form-input mt-1 block w-full" value="{{ request('client_name') }}" autocomplete="off">
                <div id="dropdown" class="absolute bg-white border border-gray-300 mt-1 rounded shadow-lg hidden dropdown-scroll"></div>
            </div>

            <!-- Filtre par nom du contact
            <div>
                <label for="contact_name" class="block text-gray-700">Nom du Contact</label>
                <input type="text" name="contact_name" id="contact_name" class="form-input mt-1 block w-full" value="{{ request('contact_name') }}">
            </div>
            -->
            <!-- Filtre par statut -->
            <div>
                <label for="statut" class="block text-gray-700">Statut</label>
                <select name="statut" id="statut" class="form-select mt-1 block w-full">
                    <option value="">Tous</option>
                    @foreach($statuts as $statut)
                        <option value="{{ $statut->id_statut }}" {{ request('statut') == $statut->id_statut ? 'selected' : '' }}>
                            {{ $statut->libelle }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Filtre par technicien -->
            <div>
                <label for="technicien" class="block text-gray-700">Technicien</label>
                <select name="technicien" id="technicien" class="form-select mt-1 block w-full">
                    <option value="">Tous</option>
                    @foreach($techniciens as $technicien)
                        <option value="{{ $technicien->id_technicien }}" {{ request('technicien') == $technicien->id_technicien ? 'selected' : '' }}>
                            {{ $technicien->nom }} {{ $technicien->prenom }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Filtre par service -->
            <div>
                <label for="service" class="block text-gray-700">Service</label>
                <select name="service" id="service" class="form-select mt-1 block w-full">
                    <option value="">Tous</option>
                    @foreach($services as $service)
                        <option value="{{ $service->id_service }}" {{ request('service') == $service->id_service ? 'selected' : '' }}>
                            {{ $service->libelle }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Filtre par catégorie -->
            <div>
                <label for="categorie" class="block text-gray-700">Catégorie</label>
                <select name="categorie" id="categorie" class="form-select mt-1 block w-full">
                    <option value="">Tous</option>
                    @foreach($categories as $categorie)
                        <option value="{{ $categorie->id_categorie }}" {{ request('categorie') == $categorie->id_categorie ? 'selected' : '' }}>
                            {{ $categorie->libelle }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Filtre par fonction -->
            <div>
                <label for="fonction" class="block text-gray-700">Fonction</label>
                <select name="fonction" id="fonction" class="form-select mt-1 block w-full">
                    <option value="">Tous</option>
                    @foreach($fonctions as $fonction)
                        <option value="{{ $fonction->id_fonction }}" {{ request('fonction') == $fonction->id_fonction ? 'selected' : '' }}>
                            {{ $fonction->libelle }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Filtre par date -->
            <div>
                <label for="date" class="block text-gray-700">Date</label>
                <input type="date" name="date" id="date" class="form-input mt-1 block w-full" value="{{ request('date') }}">
            </div>
        </div>

        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            Rechercher
        </button>
    </form>

    <!-- Affichage des tickets filtrés -->
    @if(isset($tickets) && $tickets->count() > 0)
        <div class="overflow-x-auto">
            <div class="min-w-screen flex justify-center font-sans">
                <div class="w-full lg:w-9/10">
                    <div class="bg-white shadow-md rounded my-6 overflow-x-auto">
                        <table class="min-w-full table-auto">
                            <thead>
                                <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                                    <th class="py-3 px-6 text-center">Statut</th>
                                    <th class="py-3 px-6 text-left">ID</th>
                                    <th class="py-3 px-6 text-left">Titre</th>
                                    <th class="py-3 px-6 text-left">Client</th>
                                    <th class="py-3 px-6 text-center">Technicien</th>
                                    <th class="py-3 px-6 text-center">Date</th>
                                    <th class="py-3 px-6 text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-600 text-sm font-light">
                                @foreach ($tickets as $ticket)
                                    <tr class="border-b border-gray-200 hover:bg-gray-100">
                                        <td class="py-3 px-6 text-center">{{ $ticket->statut->libelle }}</td>
                                        <td class="py-3 px-6 text-left whitespace-nowrap">{{ $ticket->id_ticket }}</td>
                                        <td class="py-3 px-6 text-left">{{ $ticket->titre }}</td>
                                        <td class="py-3 px-6 text-left">{{ $ticket->client->CT_Num }}</td>
                                        <td class="py-3 px-6 text-center">{{ $ticket->technicien->nom }} {{ $ticket->technicien->prenom }}</td>
                                        <td class="py-3 px-6 text-center">{{ \Carbon\Carbon::parse($ticket->created_at)->format('d/m/Y') }}</td>
                                        <td class="py-3 px-6 text-center">
                                            <a href="{{ route('ticket.edit', ['id' => $ticket->id_ticket]) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                                Éditer
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
        <p class="text-center text-gray-500">Aucun ticket trouvé pour les critères de recherche.</p>
    @endif

<script>
document.getElementById('client_name').addEventListener('input', function() {
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
                            document.getElementById('client_name').value = client.CT_Num;
                            // Utilisation de setTimeout pour garantir que le DOM est mis à jour correctement
                            setTimeout(function() {
                                dropdown.classList.add('hidden');
                            }, 50);
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

// Masquer le dropdown si on clique en dehors du champ ou du dropdown
document.addEventListener('click', function(event) {
    let dropdown = document.getElementById('dropdown');
    if (!dropdown.contains(event.target) && event.target.id !== 'client_name') {
        dropdown.classList.add('hidden');
    }
});
</script>

@endsection
