<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function index(Request $request)
    {
        // Récupération des filtres depuis la requête
        $query = Client::query();

        if ($request->filled('CT_Num')) {
            $query->where('CT_Num', 'like', '%' . $request->CT_Num . '%');
        }

        if ($request->filled('intitule')) {
            $query->where('CT_Intitule', 'like', '%' . $request->intitule . '%');
        }

        if ($request->filled('telephone')) {
            $query->where('CT_Telephone', 'like', '%' . $request->telephone . '%');
        }

        if ($request->filled('ville')) {
            $query->where('CT_Ville', 'like', '%' . $request->ville . '%');
        }

        if ($request->filled('adresse')) {
            $query->where('CT_Adresse', 'like', '%' . $request->adresse . '%');
        }

        if ($request->filled('code_postal')) {
            $query->where('CT_CodePostal', 'like', '%' . $request->code_postal . '%');
        }

        if ($request->filled('siret')) {
            $query->where('CT_Siret', 'like', '%' . $request->siret . '%');
        }

        // Paginer les résultats
        $clients = $query->paginate(25);

        return view('clients.index', compact('clients'));
    }
}
