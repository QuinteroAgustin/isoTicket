<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use App\Models\Fonction;
use App\Models\Service;
use App\Models\Status;
use App\Models\Technicien;
use App\Models\Ticket;
use Illuminate\Http\Request;

class RechercheController extends Controller
{
    public function home(Request $request)
{
    $statuts = Status::all();
    $techniciens = Technicien::all();
    $services = Service::all();
    $categories = Categorie::all();
    $fonctions = Fonction::all();

    $tickets = collect(); // Initialise une collection vide

    // Vérifier si des filtres sont appliqués
    if ($request->hasAny(['ticket_id', 'ticket_titre', 'client_name', 'contact_name', 'statut', 'technicien', 'service', 'categorie', 'fonction', 'date', 'message'])) {
        // Requête de base pour les tickets
        $query = Ticket::query();

        // Appliquer les filtres si présents
        if ($request->filled('ticket_id')) {
            $query->where('id_ticket', $request->input('ticket_id'));
        }

        if ($request->filled('ticket_titre')) {
            $query->where('titre', 'like', '%' .$request->input('ticket_titre'). '%');
        }

        if ($request->filled('client_name')) {
            $query->where('id_client', 'like', '%' .$request->input('client_name'). '%');
        }
        /*En attente de trouver une autre solution
        if ($request->filled('contact_name')) {
            $query->whereHas('lignes.contactCbmarq', function ($q) use ($request) {
                $q->where('Nom', 'like', '%' . $request->input('contact_name') . '%');
            });
        }
        */
        if ($request->filled('statut')) {
            $query->where('id_statut', $request->input('statut'));
        }
        if ($request->filled('technicien')) {
            $query->where('id_technicien', $request->input('technicien'));
        }
        if ($request->filled('service')) {
            $query->where('id_service', $request->input('service'));
        }
        if ($request->filled('categorie')) {
            $query->where('id_categorie', $request->input('categorie'));
        }
        if ($request->filled('fonction')) {
            $query->where('id_fonction', $request->input('fonction'));
        }
        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->input('date'));
        }

        // Nouveau filtre par message dans ticket_lignes
        if ($request->filled('message')) {
            $query->whereHas('lignes', function ($q) use ($request) {
                $q->where('text', 'like', '%' . $request->input('message') . '%');
            });
        }

        // Tri des tickets par ID décroissant
        $query->orderBy('id_ticket', 'desc');

        // Récupérer les tickets filtrés
        $tickets = $query->get();
    }

    return view('recherche.home', compact('statuts', 'techniciens', 'services', 'categories', 'fonctions', 'tickets'));

}

}
