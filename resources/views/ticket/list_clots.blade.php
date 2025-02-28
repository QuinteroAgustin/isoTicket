@extends('layouts.app')
@section('title', 'Tickets clos')
@section('page_title', 'Liste des tickets clots')

@section('content')
<style>
    .dropdown-scroll {
        max-height: 200px;
        overflow-y: auto;
    }
</style>

<div id="tickets-container">
    <h1 class="text-2xl font-semibold">Tickets Clôturés <span class="font-bold" id="tickets-count">{{ $tickets->count() }}</span></h1>
    <div class="overflow-x-auto overflow-y-auto">
        <div class="min-w-screen flex justify-center font-sans">
            <div class="w-full lg:w-9/10">
                <div class="bg-white shadow-md rounded my-6 overflow-x-auto">
                    <table class="min-w-full table-auto">
                        <thead>
                            <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                                <th class="py-3 px-6 text-center">Actions</th>
                                <th class="py-3 px-6 text-left">ID</th>
                                <th class="py-3 px-6 text-left">Titre</th>
                                <th class="py-3 px-6 text-left">Client</th>
                                <th class="py-3 px-6 text-left">Contact</th>
                                <th class="py-3 px-6 text-left">Technicien</th>
                                <th class="py-3 px-6 text-center">Risque</th>
                                <th class="py-3 px-6 text-center">Categorie</th>
                                <th class="py-3 px-6 text-center">Fonction</th>
                                <th class="py-3 px-6 text-center">Service</th>
                                <th class="py-3 px-6 text-center">Date</th>
                                <th class="py-3 px-6 text-center">Date Cloture</th>
                                <th class="py-3 px-6 text-center">CRI</th>
                            </tr>
                            <tr id="filter-form">
                                <td>
                                    <button type="button" id="search-button" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                        Rechercher
                                    </button>
                                </td>
                                <td>
                                    <div>
                                        <input type="text" name="ticket_id" id="ticket_id" class="form-input mt-1 block w-full">
                                    </div>
                                </td>
                                <td>
                                    <div>
                                        <input type="text" name="ticket_titre" id="ticket_titre" class="form-input mt-1 block w-full" autocomplete="off">
                                    </div>
                                </td>
                                <td>
                                    <div class="relative">
                                        <input type="text" name="client_name" id="client_name" class="form-input mt-1 block w-full" autocomplete="off">
                                        <div id="client-dropdown" class="absolute bg-white border border-gray-300 mt-1 rounded shadow-lg hidden dropdown-scroll w-full z-50"></div>
                                    </div>
                                </td>
                                <td>
                                    <div class="relative">
                                        <input type="text" name="contact_name" id="contact_name" class="form-input mt-1 block w-full" autocomplete="off">
                                        <input type="hidden" name="contact_id" id="contact_id">
                                        <div id="contact-dropdown" class="absolute bg-white border border-gray-300 mt-1 rounded shadow-lg hidden dropdown-scroll w-full z-50"></div>
                                    </div>
                                </td>
                                <td>
                                    <div>
                                        <select name="technicien" id="technicien" class="form-select mt-1 block w-full">
                                            <option value="">Tous</option>
                                            @foreach($techniciens as $technicien)
                                                <option value="{{ $technicien->id_technicien }}">
                                                    {{ $technicien->nom }} {{ $technicien->prenom }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </td>
                                <td>
                                    <div>
                                        <select name="risque" id="risque" class="form-select mt-1 block w-full">
                                            <option value="">Tous</option>
                                            @foreach($risques as $risque)
                                                <option value="{{ $risque->id_risque }}">
                                                    {{ $risque->libelle }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </td>
                                <td>
                                    <div>
                                        <select name="categorie" id="categorie" class="form-select mt-1 block w-full">
                                            <option value="">Tous</option>
                                            @foreach($categories as $categorie)
                                                <option value="{{ $categorie->id_categorie }}">
                                                    {{ $categorie->libelle }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </td>
                                <td>
                                    <div>
                                        <select name="fonction" id="fonction" class="form-select mt-1 block w-full">
                                            <option value="">Tous</option>
                                            @foreach($fonctions as $fonction)
                                                <option value="{{ $fonction->id_fonction }}">
                                                    {{ $fonction->libelle }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </td>
                                <td>
                                    <div>
                                        <select name="service" id="service" class="form-select mt-1 block w-full">
                                            <option value="">Tous</option>
                                            @foreach($services as $service)
                                                <option value="{{ $service->id_service }}">
                                                    {{ $service->libelle }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </td>
                                <td>
                                    <div>
                                        <input type="date" name="date" id="date" class="form-input mt-1 block w-full">
                                    </div>
                                </td>
                                <td>
                                    <div>
                                        <input type="date" name="date_clot" id="date_clot" class="form-input mt-1 block w-full">
                                    </div>
                                </td>
                                <td>
                                    <div>
                                        <select name="cri" id="cri" class="form-select mt-1 block w-full">
                                            <option value="">Tous</option>
                                            <option value="1">Oui</option>
                                            <option value="0">Non</option>
                                        </select>
                                    </div>
                                </td>
                            </tr>
                        </thead>
                        <tbody id="tickets-table-body" class="text-black text-sm">
                            <!-- Le contenu sera injecté dynamiquement ici -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div id="pagination-container" class="pagination">
        <!-- La pagination sera injectée dynamiquement ici -->
    </div>
</div>

<script>
let currentPage = 1;
let lastSearchParams = new URLSearchParams();
let autoRefreshInterval;

function getFilterParams() {
    const params = new URLSearchParams();
    
    const filters = {
        'ticket_id': document.getElementById('ticket_id').value,
        'ticket_titre': document.getElementById('ticket_titre').value,
        'client_name': document.getElementById('client_name').value,
        'contact_id': document.getElementById('contact_id').value,
        'technicien': document.getElementById('technicien').value,
        'risque': document.getElementById('risque').value,
        'categorie': document.getElementById('categorie').value,
        'fonction': document.getElementById('fonction').value,
        'service': document.getElementById('service').value,
        'date': document.getElementById('date').value,
        'date_clot': document.getElementById('date_clot').value,
        'cri': document.getElementById('cri').value
    };

    Object.entries(filters).forEach(([key, value]) => {
        if (value) params.append(key, value);
    });
    
    params.append('page', currentPage);
    return params;
}

function updateTicketsTable(isAutoRefresh = false) {
    const params = getFilterParams();
    
    if (isAutoRefresh && params.toString() === lastSearchParams.toString()) {
        params.append('auto_refresh', '1');
    }

    axios.get('{{ route("ticket.clots") }}', { params })
        .then(response => {
            if (!isAutoRefresh || response.data.hasChanges) {
                document.getElementById('tickets-table-body').innerHTML = response.data.html;
                document.getElementById('tickets-count').textContent = response.data.count;
                document.getElementById('pagination-container').innerHTML = response.data.pagination;
                
                if (!isAutoRefresh) {
                    window.history.pushState({}, '', `${window.location.pathname}?${params}`);
                    lastSearchParams = params;
                }
            }
        })
        .catch(error => console.error('Erreur lors de la mise à jour:', error));
}

// Gestionnaire de recherche
document.getElementById('search-button').addEventListener('click', function() {
    currentPage = 1;
    updateTicketsTable();
});

// Gestionnaire de pagination
document.addEventListener('click', function(e) {
    if (e.target.matches('.pagination a')) {
        e.preventDefault();
        currentPage = new URLSearchParams(e.target.href.split('?')[1]).get('page') || 1;
        updateTicketsTable();
    }
});

// Recherche de clients
document.getElementById('client_name').addEventListener('input', function() {
    let search = this.value.trim();
    if (search.length > 0) {
        axios.get('{{ route("search.clients") }}', { params: { search: search } })
            .then(response => {
                let dropdown = document.getElementById('client-dropdown');
                dropdown.innerHTML = '';
                if (response.data.length > 0) {
                    response.data.forEach(client => {
                        let div = document.createElement('div');
                        div.classList.add('p-2', 'cursor-pointer', 'hover:bg-gray-200');
                        div.textContent = `${client.CT_Num} - ${client.CT_Intitule}`;
                        div.addEventListener('click', function() {
                            document.getElementById('client_name').value = client.CT_Num;
                            dropdown.classList.add('hidden');
                            updateTicketsTable();
                        });
                        dropdown.appendChild(div);
                    });
                    dropdown.classList.remove('hidden');
                } else {
                    dropdown.classList.add('hidden');
                }
            });
    } else {
        document.getElementById('client-dropdown').classList.add('hidden');
    }
});

// Recherche de contacts
document.getElementById('contact_name').addEventListener('input', function() {
    let search = this.value.trim();
    if (search.length > 0) {
        axios.get('{{ route("search.contacts") }}', { params: { search: search } })
            .then(response => {
                let dropdown = document.getElementById('contact-dropdown');
                dropdown.innerHTML = '';
                if (response.data.length > 0) {
                    response.data.forEach(contact => {
                        let div = document.createElement('div');
                        div.classList.add('p-2', 'cursor-pointer', 'hover:bg-gray-200');
                        div.textContent = `${contact.CT_Nom} ${contact.CT_Prenom}`;
                        div.addEventListener('click', function() {
                            document.getElementById('contact_name').value = `${contact.CT_Nom} ${contact.CT_Prenom}`;
                            document.getElementById('contact_id').value = contact.cbMarq;
                            dropdown.classList.add('hidden');
                            updateTicketsTable();
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
        document.getElementById('contact_id').value = '';
    }
});

// Gestionnaire de changement pour les selects
const selectElements = ['technicien', 'risque', 'categorie', 'fonction', 'service', 'cri'];
selectElements.forEach(elementId => {
    document.getElementById(elementId).addEventListener('change', function() {
        currentPage = 1;
        updateTicketsTable();
    });
});

// Gestionnaire de changement pour les dates
const dateElements = ['date', 'date_clot'];
dateElements.forEach(elementId => {
    document.getElementById(elementId).addEventListener('change', function() {
        currentPage = 1;
        updateTicketsTable();
    });
});

// Gestionnaire de clic en dehors des dropdowns
document.addEventListener('click', function(event) {
    const clientDropdown = document.getElementById('client-dropdown');
    const contactDropdown = document.getElementById('contact-dropdown');
    
    if (!event.target.closest('#client_name') && clientDropdown) {
        clientDropdown.classList.add('hidden');
    }
    
    if (!event.target.closest('#contact_name') && contactDropdown) {
        contactDropdown.classList.add('hidden');
    }
});

// Initialisation
document.addEventListener('DOMContentLoaded', function() {
    updateTicketsTable();
    
    // Démarrer l'auto-refresh
    autoRefreshInterval = setInterval(() => {
        updateTicketsTable(true);
    }, 1000); // Actualisation toutes les 30 secondes
});

// Nettoyage
window.addEventListener('beforeunload', function() {
    if (autoRefreshInterval) {
        clearInterval(autoRefreshInterval);
    }
});
</script>
@endsection