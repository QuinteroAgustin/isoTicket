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
            $query->where('CT_Num', 'like', '%' . $request->input('CT_Num') . '%');
        }

        if ($request->filled('CT_Intitule')) {
            $query->where('CT_Intitule', 'like', '%' . $request->input('CT_Intitule') . '%');
        }

        if ($request->filled('CT_Telephone')) {
            $query->where('CT_Telephone', 'like', '%' . $request->input('CT_Telephone') . '%');
        }

        if ($request->filled('CT_Ville')) {
            $query->where('CT_Ville', 'like', '%' . $request->input('CT_Ville') . '%');
        }

        if ($request->filled('CT_Adresse')) {
            $query->where('CT_Adresse', 'like', '%' . $request->input('CT_Adresse') . '%');
        }

        if ($request->filled('CT_CodePostal')) {
            $query->where('CT_CodePostal', 'like', '%' . $request->input('CT_CodePostal') . '%');
        }

        if ($request->filled('CT_Siret')) {
            $query->where('CT_Siret', 'like', '%' . $request->input('CT_Siret') . '%');
        }

        // Paginer les résultats
        $clients = $query->paginate(25);

        return view('clients.index', compact('clients'));
    }
}
