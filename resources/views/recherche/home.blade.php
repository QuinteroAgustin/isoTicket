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

            <!-- Filtre par titre ticket -->
            <div>
                <label for="ticket_titre" class="block text-gray-700">Titre du Ticket</label>
                <input type="text" name="ticket_titre" id="ticket_titre" class="form-input mt-1 block w-full" value="{{ request('ticket_titre') }}" autocomplete="off">
            </div>

            <!-- Filtre par nom du client -->
            <div>
                <label for="client_name" class="block text-gray-700">Nom du Client</label>
                <input type="text" name="client_name" id="client_name" class="form-input mt-1 block w-full" value="{{ request('client_name') }}" autocomplete="off">
                <div id="dropdown" class="absolute bg-white border border-gray-300 mt-1 rounded shadow-lg hidden dropdown-scroll"></div>
            </div>
            <!-- Ajouter après le filtre client_name -->
            <div>
                <label for="contact_name" class="block text-gray-700">Contact</label>
                <input type="text" name="contact_name_display" id="contact_name" class="form-input mt-1 block w-full" autocomplete="off">
                <input type="hidden" name="contact_id" id="contact_id">
                <div id="contact-dropdown" class="absolute bg-white border border-gray-300 mt-1 rounded shadow-lg hidden dropdown-scroll"></div>
            </div>
            <!-- Filtre par cri -->
            <div>
                <label for="cri" class="block text-gray-700">CRI</label>
                <select name="cri" id="cri" class="form-select mt-1 block w-full">
                    <option value="">Tous</option>
                    <option value="1" {{ request('cri') == '1' ? 'selected' : '' }}>Oui</option>
                    <option value="0" {{ request('cri') == '0' ? 'selected' : '' }}>Non</option>
                </select>
            </div>
            <!-- Filtre par risque -->
            <div>
                <label for="risque" class="block text-gray-700">Risque</label>
                <select name="risque" id="risque" class="form-select mt-1 block w-full">
                    <option value="">Tous</option>
                    @foreach($risques as $risque)
                        <option value="{{ $risque->id_risque }}" {{ request('risque') == $risque->id_risque ? 'selected' : '' }}>
                            {{ $risque->libelle }}
                        </option>
                    @endforeach
                </select>
            </div>
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
            <div>
                <label for="date_cloture" class="block text-gray-700">Date de clôture</label>
                <input type="date" name="date_cloture" id="date_cloture" 
                    class="form-input mt-1 block w-full" 
                    value="{{ request('date_cloture') }}">
            </div>

            <!-- Filtre par message -->
            <div>
                <label for="message" class="block text-gray-700">Message</label>
                <input type="text" name="message" id="message" class="form-input mt-1 block w-full" value="{{ request('message') }}">
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
                                    <th class="py-3 px-6 text-left">Contact</th>
                                    <th class="py-3 px-6 text-center">Technicien</th>
                                    <th class="py-3 px-6 text-center">Date</th>
                                    <th class="py-3 px-6 text-center">CRI</th>
                                    <th class="py-3 px-6 text-center">Risque</th>
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
                                        <td class="py-3 px-6 text-left">
                                            @if($ticket->premiereTicketLigne && $ticket->premiereTicketLigne->contactCbmarq)
                                                {{ $ticket->premiereTicketLigne->contactCbmarq->CT_Nom }} 
                                                {{ $ticket->premiereTicketLigne->contactCbmarq->CT_Prenom }}
                                            @else
                                                NA
                                            @endif
                                        </td>
                                        @if($ticket->technicien != null)
                                        <td class="py-3 px-6 text-center">{{ $ticket->technicien->nom }} {{ $ticket->technicien->prenom }}</td>
                                        @else
                                        <td class="py-3 px-6 text-center">NA</td>
                                        @endif
                                        <td class="py-3 px-6 text-center">{{ \Carbon\Carbon::parse($ticket->created_at)->format('d/m/Y') }}</td>
                                        <td class="py-3 px-6 text-center">
                                            @if($ticket->cri)
                                                <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded-full">Oui</span>
                                            @else
                                                <span class="bg-gray-100 text-gray-800 text-xs font-medium px-2.5 py-0.5 rounded-full">Non</span>
                                            @endif
                                        </td>
                                        <td class="py-3 px-6 text-center">
                                            @php
                                                $riskIcon = '';
                                                if($ticket->impact && $ticket->priorite) {
                                                    foreach ($risques as $risque) {
                                                        if ($ticket->impact->id_impact == $risque->id_impact && $ticket->priorite->id_priorite == $risque->id_priorite) {
                                                            $riskIcon = $risque->icon;
                                                            break;
                                                        }
                                                    }
                                                }
                                            @endphp
                                            @if($riskIcon)
                                                <svg class="w-12 h-6 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">{!! $riskIcon !!}</svg>
                                            @else
                                                <span class="bg-gray-100 text-gray-800 text-xs font-medium px-2.5 py-0.5 rounded-full">NA</span>
                                            @endif
                                        </td>
                                        <td class="py-3 px-6 text-center">
                                            <a href="{{ route('ticket.edit', ['id' => $ticket->id_ticket]) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" target="_blank">
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

document.getElementById('contact_name').addEventListener('input', function() {
    let search = this.value.trim();
    let contactInput = this;
    let contactId = document.getElementById('contact_id');
    
    if (search.length > 0) {
        axios.get('{{ route("search.contacts") }}', { params: { search: search } })
            .then(response => {
                let contacts = response.data;
                let dropdown = document.getElementById('contact-dropdown');
                dropdown.innerHTML = '';
                if (contacts.length > 0) {
                    contacts.forEach(contact => {
                        let div = document.createElement('div');
                        div.classList.add('p-2', 'cursor-pointer', 'hover:bg-gray-200');
                        div.textContent = `${contact.CT_Nom} ${contact.CT_Prenom}`;
                        div.addEventListener('click', function() {
                            contactInput.value = `${contact.CT_Nom} ${contact.CT_Prenom}`;
                            contactId.value = contact.cbMarq;
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
        document.getElementById('contact-dropdown').classList.add('hidden');
        hiddenInput.value = '';
    }
});

// Masquer le dropdown des contacts
document.addEventListener('click', function(event) {
    let dropdownContact = document.getElementById('contact-dropdown');
    if (dropdownContact && !dropdownContact.contains(event.target) && event.target.id !== 'contact_name') {
        dropdownContact.classList.add('hidden');
    }
});
</script>

@endsection
