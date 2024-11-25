<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Contact;
use App\Models\Abonnement;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function index(Request $request)
    {
        try{
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
        } catch (\Exception $e) {
            // Retournez une réponse en cas d'erreur
            return redirect()->back()->with('error', 'Erreur lors de la recherche du client.');
        }
    }

    public function info($id)
    {
        try{
            $client = Client::where('CT_Num', $id)->First();
            $contacts = Contact::where('CT_Num', $id)->get();
            $abonnements = Abonnement::where('CT_Num', $id)->with('lignes')->get();

            return view('clients.info', compact('client', 'contacts', 'abonnements'));
        } catch (\Exception $e) {
            // Retournez une réponse en cas d'erreur
            return redirect()->back()->with('error', 'Erreur lors de l\'affichage du client.'. $e->getMessage());
        }
    }

    public function editContact($idcontact)
    {

        $contact = Contact::where('cbMarq', $idcontact)->firstOrFail();
        $client = Client::where('CT_Num', $contact->CT_Num)->First();


        return view('clients.editContact', compact('client', 'contact'));
    }

    public function editContactPost(Request $request)
    {
        try{
            $contact = Contact::where('cbMarq', $request->id_contact)->firstOrFail();

            $contact->CT_Nom = $request->nom;
            $contact->CT_Prenom = $request->prenom;
            $contact->CT_Fonction = $request->fonction;
            $contact->CT_Telephone = $request->telephone;
            $contact->CT_TelPortable = $request->portable;
            $contact->CT_EMail = $request->email;
            $contact->save();

            return redirect()->route('clients.info', ['id' => $contact->CT_Num])->with('success', 'Edition du contact '. $request->nom .' '. $request->prenom .' avec succès!');
        } catch (\Exception $e) {
            // Retournez une réponse en cas d'erreur
            return redirect()->back()->with('error', 'Erreur lors de l\'édition du contact.');
        }
    }

    public function createContact($idClient)
    {
        $client = Client::where('CT_Num', $idClient)->First();

        return view('clients.createContact', compact('client'));
    }

    public function createContactPost(Request $request)
    {
        try{
            $validatedData = $request->validate([
                'nom' => 'required|string',
                'prenom' => 'required|string',
                'fonction' => 'nullable|string',
                'telephone' => 'nullable',
                'portable' => 'nullable',
                'email' => 'nullable|email',
            ]);
            //dd($request->id_client);
            $client = Client::where('CT_Num', $request->id_client)->First();

            $contact = new Contact();
            $contact->CT_Num = $client->CT_Num;
            $contact->CT_Nom = $validatedData['nom'];
            $contact->CT_Prenom = $validatedData['prenom'];
            $contact->CT_Fonction = $validatedData['fonction'];
            $contact->CT_Telephone = $validatedData['telephone'];
            $contact->CT_TelPortable = $validatedData['portable'];
            $contact->CT_EMail = $validatedData['email'];

            $contact->save();

            return redirect()->route('clients.info', ['id' => $client->CT_Num])->with('success', 'Création du contact '. $request->nom .' '. $request->prenom .' avec succès!');
        } catch (\Exception $e) {
            // Retournez une réponse en cas d'erreur
            return redirect()->back()->with('error', 'Erreur lors de la création du contact.');
        }
    }
}
