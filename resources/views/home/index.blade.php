@extends('layouts.app')

@section('title', 'Tableau de bord')

@section('content')
<h1 class="text-2xl font-semibold">Statistiques</h1>
<div id="ticket-stats" class="grid grid-cols-3 gap-3 mb-2">
    @include('home.render.ticket_stats', [
        'tickets' => $tickets,
        'ticketsJour' => $ticketsJour,
        'ticketsClotsJour' => $ticketsClotsJour,
        'ticketsClots' => $ticketsClots,
        'pourcentageDifference' => $pourcentageDifference,
        'dateFormatted' => $dateFormatted,
    ])
</div>
@endsection

@section('scripts')
<script>
    // Fonction pour rafraîchir les données des tickets
    function refreshTicketStats() {
        axios.get('{{ route("refreshTicketsData") }}')
            .then(function(response) {
                // Met à jour le contenu HTML avec la réponse
                document.getElementById('ticket-stats').innerHTML = response.data.html;
            })
            .catch(function(error) {
                console.error("Erreur lors de l'actualisation des données :", error);
            });
    }

    // Rafraîchissement automatique des données toutes les secondes
    setInterval(refreshTicketStats, 1000);
</script>
@endsection
