<?php

namespace App\Http\Controllers;

use App\Models\Risque;
use App\Models\Status;
use App\Models\Ticket;
use App\Models\Service;
use App\Models\Fonction;
use App\Models\Categorie;
use App\Models\Technicien;
use Illuminate\Http\Request;

class RechercheController extends Controller
{
    public function home(Request $request)
{
    $statuts = Status::all();
    $techniciens = Technicien::where(function($query) {
        $query->whereNull('masquer')
              ->orWhere('masquer', 0);
    })->orderBy('nom')->get();
    
    $services = Service::where(function($query) {
        $query->whereNull('masquer')
              ->orWhere('masquer', 0);
    })->orderBy('libelle')->get();
    
    $categories = Categorie::where(function($query) {
        $query->whereNull('masquer')
              ->orWhere('masquer', 0);
    })->orderBy('libelle')->get();
    
    $fonctions = Fonction::where(function($query) {
        $query->whereNull('masquer')
              ->orWhere('masquer', 0);
    })->orderBy('libelle')->get();
    
    $risques = Risque::orderBy('libelle')->get();

    $tickets = collect();

    // Vérifier si des filtres sont appliqués
    if ($request->hasAny(['ticket_id', 'ticket_titre', 'client_name', 'contact_name', 'statut', 
        'technicien', 'service', 'categorie', 'fonction', 'date', 'message', 'cri', 'risque'])) {
        // Requête de base pour les tickets
        $query = Ticket::query();

        // Appliquer les filtres si présents
        if ($request->filled('ticket_id') && is_numeric($request->input('ticket_id'))) {
            $query->where('id_ticket', $request->input('ticket_id'));
        }

        if ($request->filled('ticket_titre')) {
            $query->where('titre', 'like', '%' .$request->input('ticket_titre'). '%');
        }

        if ($request->filled('client_name')) {
            $query->where('id_client', 'like', '%' .$request->input('client_name'). '%');
        }
        // Filtre Risque
        if ($request->filled('risque')) {
            $risque = $request->input('risque');
            $query->whereHas('impact', function($q) use ($risque) {
                $q->whereHas('risques', function($q) use ($risque) {
                    $q->where('id_risque', $risque);
                });
            });
        }
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
        // Filtre CRI
        if ($request->filled('cri')) {
            $query->where('cri', $request->input('cri'));
        }

        // Nouveau filtre par message dans ticket_lignes
        if ($request->filled('message')) {
            $query->whereHas('lignes', function ($q) use ($request) {
                $q->where('text', 'like', '%' . $request->input('message') . '%');
            });
        }

        $tickets = $query->orderBy('id_ticket', 'desc')->get();


    }

    return view('recherche.home', compact('statuts', 'techniciens', 'services', 
        'categories', 'fonctions', 'tickets', 'risques'));

    }
}
