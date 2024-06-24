<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function index(Request $request)
    {
        // Récupérer les clients avec une pagination
        $clients = Client::paginate(10);

        // Obtenez l'URL de la route de filtrage
        $filterUrl = route('clients.filter');

        // Si la requête contient des paramètres de filtre, appliquez ces filtres aux clients
        if ($request->filled('telephone') || $request->filled('ville') || $request->filled('code_postal') || $request->filled('code_client') || $request->filled('nom_client')) {
            $clients = $this->applyFilters($request, $clients);
        }

        // Si la requête est une requête AJAX, renvoyer uniquement le contenu du tableau des clients
        if ($request->ajax()) {
            return view('clients.client_table', compact('clients'))->render();
        }

        // Sinon, retourner la vue complète avec les clients, l'URL de filtrage et la pagination
        return view('clients.index', compact('clients', 'filterUrl'));
    }

    private function applyFilters(Request $request, $query)
    {
        if ($request->filled('telephone')) {
            $query->where('CT_Telephone', 'LIKE', '%' . $request->input('telephone') . '%');
        }

        if ($request->filled('ville')) {
            $query->where('CT_Ville', 'LIKE', '%' . $request->input('ville') . '%');
        }

        if ($request->filled('code_postal')) {
            $query->where('CT_CodePostal', 'LIKE', '%' . $request->input('code_postal') . '%');
        }

        if ($request->filled('code_client')) {
            $query->where('CT_Num', 'LIKE', '%' . $request->input('code_client') . '%');
        }

        if ($request->filled('nom_client')) {
            $query->where('CT_Intitule', 'LIKE', '%' . $request->input('nom_client') . '%');
        }

        return $query->paginate(10);
    }

    public function filter(Request $request)
    {
        $telephone = $request->input('telephone');
        $ville = $request->input('ville');
        $code_postal = $request->input('code_postal');
        $code_client = $request->input('code_client');
        $nom_client = $request->input('nom_client');

        $query = Client::query();

        // Récupérez les paramètres de filtrage de l'URL
        $params = $request->query();

        if ($telephone) {
            $query->where('CT_Telephone', 'LIKE', '%' . $telephone . '%');
        }

        if ($ville) {
            $query->where('CT_Ville', 'LIKE', '%' . $ville . '%');
        }

        if ($code_postal) {
            $query->where('CT_CodePostal', 'LIKE', '%' . $code_postal . '%');
        }

        if ($code_client) {
            $query->where('CT_Num', 'LIKE', '%' . $code_client . '%');
        }

        if ($nom_client) {
            $query->where('CT_Intitule', 'LIKE', '%' . $nom_client . '%');
        }

        $clients = $query->paginate(10000);

        // Retourne la vue partielle avec les clients filtrés
        return view('clients.client_table', compact('clients'));
    }
}
