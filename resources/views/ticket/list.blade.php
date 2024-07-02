@extends('layouts.app')
@section('title', 'Tickets')
@section('page_title', 'Liste des tickets')

@section('content')
    <!-- Your Page Content Here -->
    <h1 class="text-2xl font-semibold">Tickets</h1>
    <div class="overflow-x-auto">
        <div class="min-w-screen flex items-center justify-center font-sans overflow-y-auto min-h-[60vh] max-h-[60vh]">
            <div class="w-full lg:w-9/10">
                <div class="bg-white shadow-md mt-20 rounded my-6 overflow-x-auto">
                    <table class="min-w-full table-auto">
                        <thead>
                            <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                                <th class="py-3 px-6 text-center">Statut</th>
                                <th class="py-3 px-6 text-left">ID</th>
                                <th class="py-3 px-6 text-left">Titre</th>
                                <th class="py-3 px-6 text-left">Client</th>
                                <th class="py-3 px-6 text-left">Technicien</th>
                                <th class="py-3 px-6 text-center">Risque</th>
                                <th class="py-3 px-6 text-center">Categorie</th>
                                <th class="py-3 px-6 text-center">Fonction</th>
                                <th class="py-3 px-6 text-center">
                                    <div class="flex items-center">
                                        <span>Service</span>
                                        <a href="{{ route('ticket', ['sort' => ($sort == 'asc') ? 'desc' : 'asc']) }}" class="ml-1.5">
                                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M8.574 11.024h6.852a2.075 2.075 0 0 0 1.847-1.086 1.9 1.9 0 0 0-.11-1.986L13.736 2.9a2.122 2.122 0 0 0-3.472 0L6.837 7.952a1.9 1.9 0 0 0-.11 1.986 2.074 2.074 0 0 0 1.847 1.086Zm6.852 1.952H8.574a2.072 2.072 0 0 0-1.847 1.087 1.9 1.9 0 0 0 .11 1.985l3.426 5.05a2.123 2.123 0 0 0 3.472 0l3.427-5.05a1.9 1.9 0 0 0 .11-1.985 2.074 2.074 0 0 0-1.846-1.087Z"/>
                                            </svg>
                                        </a>
                                    </div>
                                </th>
                                <th class="py-3 px-6 text-center">
                                    <div class="flex items-center">
                                        <span>Date</span>
                                        <a href="{{ route('ticket', ['sortDate' => ($sortDate == 'asc') ? 'desc' : 'asc']) }}" class="ml-1.5">
                                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M8.574 11.024h6.852a2.075 2.075 0 0 0 1.847-1.086 1.9 1.9 0 0 0-.11-1.986L13.736 2.9a2.122 2.122 0 0 0-3.472 0L6.837 7.952a1.9 1.9 0 0 0-.11 1.986 2.074 2.074 0 0 0 1.847 1.086Zm6.852 1.952H8.574a2.072 2.072 0 0 0-1.847 1.087 1.9 1.9 0 0 0 .11 1.985l3.426 5.05a2.123 2.123 0 0 0 3.472 0l3.427-5.05a1.9 1.9 0 0 0 .11-1.985 2.074 2.074 0 0 0-1.846-1.087Z"/>
                                            </svg>
                                        </a>
                                    </div>
                                </th>
                                <th class="py-3 px-6 text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600 text-sm font-light">
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
                                @endphp
                                <tr class="border-b border-gray-200 {{ $bgColor }} hover:bg-gray-100">
                                    <td class="py-3 px-6 text-center">{{ $ticket->statut->libelle }}</td>
                                    <td class="py-3 px-6 text-left whitespace-nowrap">{{ $ticket->id_ticket }}</td>
                                    <td class="py-3 px-6 text-left">{{ $ticket->titre }}</td>
                                    <td class="py-3 px-6 text-left">{{ $ticket->client->CT_Num }}</td>
                                    <td class="py-3 px-6 text-center">{{ $ticket->technicien->nom }} {{ $ticket->technicien->prenom }}</td>
                                    <td class="py-3 px-6 text-center">
                                        @if($riskIcon)
                                            <svg class="w-6 h-3 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">{!! $riskIcon !!}</svg>
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
@endsection
