@foreach ($tickets as $ticket)
    @php
        $bgColor = '';
        $riskIcon = '';
        // Vérification des risques une seule fois
        $currentRisque = $risques->first(function($risque) use ($ticket) {
            return $ticket->impact->id_impact == $risque->id_impact && 
                   $ticket->priorite->id_priorite == $risque->id_priorite;
        });
        
        if ($currentRisque) {
            $bgColor = $currentRisque->fond;
            $riskIcon = $currentRisque->icon;
        }
        
        $truncatedTitre = Str::limit($ticket->titre, 25, '...');
    @endphp
    <tr class="border-b border-gray-200 hover:bg-gray-100 {{ $bgColor ? $bgColor : 'even:bg-gray-100' }}">
        <td class="py-3 px-6 text-center">
            <a href="{{ route('ticket.edit', ['id' => $ticket->id_ticket]) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Éditer
            </a>
        </td>
        <td class="py-3 px-6 text-center">{{ $ticket->statut->libelle }}</td>
        <td class="py-3 px-6 text-left whitespace-nowrap">{{ $ticket->id_ticket }}</td>
        <td class="py-3 px-6 text-left">
            <span title="{{ $ticket->titre }}">{{ $truncatedTitre }}</span>
        </td>
        <td class="py-3 px-6 text-left">{{ $ticket->client->CT_Num ?? 'NA' }}</td>
        <td class="py-3 px-6 text-left">
            @if($ticket->premiereTicketLigne && $ticket->premiereTicketLigne->contactCbmarq)
                {{ $ticket->premiereTicketLigne->contactCbmarq->CT_Nom }}
                {{ $ticket->premiereTicketLigne->contactCbmarq->CT_Prenom }}
            @else
                NA
            @endif
        </td>
        <td class="py-3 px-6 text-center">
            {{ $ticket->technicien ? $ticket->technicien->nom . ' ' . $ticket->technicien->prenom : 'NA' }}
        </td>
        <td class="py-3 px-6 text-center">
            @if($riskIcon)
                <svg class="w-6 h-6 mx-auto" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    {!! $riskIcon !!}
                </svg>
            @else
                NA
            @endif
        </td>
        <td class="py-3 px-6 text-center">{{ $ticket->categorie->libelle }}</td>
        <td class="py-3 px-6 text-center">{{ $ticket->fonction->libelle }}</td>
        <td class="py-3 px-6 text-center">{{ $ticket->service->libelle }}</td>
        <td class="py-3 px-6 text-center">{{ \Carbon\Carbon::parse($ticket->created_at)->format('d/m H:i') }}</td>
    </tr>
@endforeach 