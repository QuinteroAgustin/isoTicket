@extends('layouts.app')
@section('title', 'Tickets')
@section('page_title', 'Liste des tickets')

@section('content')
<style>
    /* Ajoutez cette classe pour limiter la hauteur du dropdown et permettre le défilement */
    .dropdown-scroll {
        max-height: 200px; /* Limite à environ 5 éléments (ajustez si nécessaire) */
        overflow-y: auto;
    }

</style>
    <!-- Your Page Content Here -->
    <h1 class="text-2xl font-semibold">Tickets</h1>
    <div class="overflow-x-auto overflow-y-auto">
        <div class="min-w-screen flex justify-center font-sans">
            <div class="w-full lg:w-9/10">
                <div class="bg-white shadow-md rounded my-6 overflow-x-auto">
                    <table class="min-w-full table-auto">
                        <thead>
                            <tr class="bg-gray-200 text-black uppercase text-sm leading-normal">
                                <th class="py-3 px-6 text-center">Statut</th>
                                <th class="py-3 px-6 text-left">ID</th>
                                <th class="py-3 px-6 text-left">Titre</th>
                                <th class="py-3 px-6 text-left">Client</th>
                                <th class="py-3 px-6 text-left">Technicien</th>
                                <th class="py-3 px-6 text-center">Risque</th>
                                <th class="py-3 px-6 text-center">Categorie</th>
                                <th class="py-3 px-6 text-center">Fonction</th>
                                <th class="py-3 px-6 text-center">Service</th>
                                <th class="py-3 px-6 text-center">Date</th>
                                <th class="py-3 px-6 text-center">Actions</th>
                            </tr>
                            <form action="{{ route('ticket') }}" method="GET">
                            <tr>
                                <td>
                                    <div>
                                        <select name="statut" id="statut" class="form-select mt-1 block w-full">
                                            <option value="">Tous</option>
                                            @foreach($statuts as $statut)
                                            @if ($statut->id_statut != 4)
                                                <option value="{{ $statut->id_statut }}" {{ request('statut') == $statut->id_statut ? 'selected' : '' }}>
                                                    {{ $statut->libelle }}
                                                </option>
                                            @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </td>
                                <td>
                                    <div>
                                        <input type="text" name="ticket_id" id="ticket_id" class="form-input mt-1 block w-full" value="{{ request('ticket_id') }}">
                                    </div>
                                </td>
                                <td>
                                    <div>
                                        <input type="text" name="ticket_titre" id="ticket_titre" class="form-input mt-1 block w-full" value="{{ request('ticket_titre') }}" autocomplete="off">
                                    </div>
                                </td>
                                <td>
                                    <div>
                                        <input type="text" name="client_name" id="client_name" class="form-input mt-1 block w-full" value="{{ request('client_name') }}" autocomplete="off">
                                        <div id="dropdown" class="absolute bg-white border border-gray-300 mt-1 rounded shadow-lg hidden dropdown-scroll"></div>
                                    </div>
                                </td>
                                <td>
                                    <div>
                                        <select name="technicien" id="technicien" class="form-select mt-1 block w-full">
                                            <option value="">Tous</option>
                                            @foreach($techniciens as $technicien)
                                                <option value="{{ $technicien->id_technicien }}" {{ request('technicien') == $technicien->id_technicien ? 'selected' : '' }}>
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
                                            <!--
                                            @foreach($risques as $risque)
                                                <option value="{{ $risque->id_risque }}" {{ request('risque') == $risque->id_risque ? 'selected' : '' }}>
                                                    {{ $risque->libelle }}
                                                </option>
                                            @endforeach
                                            -->
                                        </select>
                                    </div>
                                </td>
                                <td>
                                    <div>
                                        <select name="categorie" id="categorie" class="form-select mt-1 block w-full">
                                            <option value="">Tous</option>
                                            @foreach($categories as $categorie)
                                                <option value="{{ $categorie->id_categorie }}" {{ request('categorie') == $categorie->id_categorie ? 'selected' : '' }}>
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
                                                <option value="{{ $fonction->id_fonction }}" {{ request('fonction') == $fonction->id_fonction ? 'selected' : '' }}>
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
                                                <option value="{{ $service->id_service }}" {{ request('service') == $service->id_service ? 'selected' : '' }}>
                                                    {{ $service->libelle }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </td>
                                <td>
                                    <div>
                                        <input type="date" name="date" id="date" class="form-input mt-1 block w-full" value="{{ request('date') }}">
                                    </div>
                                </td>
                                <td>
                                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                        Rechercher
                                    </button>
                                </td>
                            </tr>
                        </form>
                        </thead>
                        <tbody class="text-black text-sm">
                            @foreach ($tickets as $ticket)
                                @php
                                    $bgColor = '';
                                    foreach ($risques as $risque) {
                                        if ($ticket->impact->id_impact == $risque->id_impact && $ticket->priorite->id_priorite == $risque->id_priorite) {
                                            $bgColor = $risque->fond;
                                            break; // Sortir de la boucle une fois la condition satisfaite
                                        }
                                    }

                                    // Initialiser l'icône de risque
                                    $riskIcon = '';
                                    foreach ($risques as $risque) {
                                        if ($ticket->impact->id_impact == $risque->id_impact && $ticket->priorite->id_priorite == $risque->id_priorite) {
                                            $riskIcon = $risque->icon;
                                            break; // Sortir de la boucle une fois l'icône trouvée
                                        }
                                    }

                                    //truncate titre
                                    $truncatedTitre = Str::limit($ticket->titre, 25, '...');
                                @endphp
                                <tr class="border-b border-gray-200 {{ $bgColor }} hover:bg-gray-100">
                                    <td class="py-3 px-6 text-center">{{ $ticket->statut->libelle }}</td>
                                    <td class="py-3 px-6 text-left whitespace-nowrap">{{ $ticket->id_ticket }}</td>
                                    <td class="py-3 px-6 text-left">
                                        <span title="{{ $ticket->titre }}">
                                            {{ $truncatedTitre }}
                                        </span>
                                    </td>
                                    <td class="py-3 px-6 text-left">{{ $ticket->client->CT_Num }}</td>
                                    @if($ticket->technicien != null)
                                    <td class="py-3 px-6 text-center">{{ $ticket->technicien->nom }} {{ $ticket->technicien->prenom }}</td>
                                    @else
                                    <td class="py-3 px-6 text-center">NA</td>
                                    @endif
                                    <td class="py-3 px-6 text-center">
                                        @if($riskIcon)
                                            <svg class="w-12 h-6 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">{!! $riskIcon !!}</svg>
                                        @else
                                            NA
                                        @endif
                                    </td>
                                    <td class="py-3 px-6 text-center">{{ $ticket->categorie->libelle }}</td>
                                    <td class="py-3 px-6 text-center">{{ $ticket->fonction->libelle }}</td>
                                    <td class="py-3 px-6 text-center">{{ $ticket->service->libelle }}</td>
                                    <td class="py-3 px-6 text-center">{{ \Carbon\Carbon::parse($ticket->created_at)->format('d/m H:i') }}</td>

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
    <!-- Liens de pagination -->
    <div class="pagination">
        {{ $tickets->appends(request()->input())->links() }}
    </div>
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
@section('scripts')
    <script>
        // Recharger la page toutes les 30 secondes
        setInterval(function() {
            location.reload();
        }, 30000); // 30000 ms = 30 secondes
    </script>
@endsection
