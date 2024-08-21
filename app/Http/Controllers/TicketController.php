<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Client;
use App\Models\Impact;
use App\Models\Risque;
use App\Models\Status;
use App\Models\Ticket;
use App\Models\Contact;
use App\Models\Forfait;
use App\Models\Service;
use App\Models\Fonction;
use App\Models\Priorite;
use App\Models\Categorie;
use App\Models\Technicien;
use App\Helpers\TimeHelper;
use App\Mail\PostMail;
use App\Mail\PostMailClose;
use App\Mail\PostMailContact;
use App\Mail\PostMailOpen;
use App\Mail\PostMailTicket;
use App\Mail\PostMailUpdate;
use App\Models\TicketLigne;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class TicketController extends Controller
{
    public function ticket(Request $request)
    {
        // Récupérer les paramètres de tri depuis la requête
        $sort = $request->input('sort', 'asc');
        $sortDate = $request->input('sortDate', 'desc');

        // Filtrer et trier les tickets
        $tickets = Ticket::where('cloture', 0)
                        ->orderBy('id_service', $sort)
                        ->orderBy('created_at', $sortDate)
                        ->get();

        $risques = Risque::all();

        return view('ticket.list', compact('tickets', 'risques', 'sort', 'sortDate'));
    }

    public function ticket_clots(Request $request)
    {
        // Récupérer les paramètres de tri depuis la requête
        $sort = $request->input('sort', 'asc');
        $sortDate = $request->input('sortDate', 'desc');

        // Filtrer et trier les tickets
        $tickets = Ticket::where('cloture', 1)
                        ->orderBy('id_service', $sort)
                        ->orderBy('created_at', $sortDate)
                        ->get();

        $risques = Risque::all();

        return view('ticket.list_clots', compact('tickets', 'risques', 'sort', 'sortDate'));
    }

    public function createVue()
    {
        $clients = Client::all();
        $techniciens = Technicien::all();
        $priorites = Priorite::all();
        $impacts = Impact::all();
        $status = Status::where('id_statut', 1)->get();
        $fonctions = Fonction::all();
        $categories = Categorie::all();
        $services = Service::all();

        return view('ticket.create', compact('clients', 'techniciens', 'priorites', 'impacts', 'status', 'fonctions', 'categories', 'services'));
    }

    public function create(Request $request)
    {
        try {
            // Validez les données du formulaire
            $request->validate([
                'titre' => 'required|string|max:255',
                'client' => 'required|exists:sqlsrv2.F_COMPTET,CT_Num',
                'technicien' => 'required|exists:techniciens,id_technicien',
                'service' => 'required|exists:services,id_service',
                'fonction' => 'required|exists:Fonctions,id_fonction',
                'categorie' => 'required|exists:Categories,id_categorie',
                'statut' => 'required|exists:Status,id_statut',
                'priorite' => 'required|exists:priorite,id_priorite',
                'impact' => 'required|exists:impact,id_impact',
            ]);
            // Créez un nouvel objet Forfait avec les données validées
            $ticket = new Ticket();
            $ticket->titre = $request->titre;
            $ticket->created_at = Carbon::now()->timezone('Europe/Paris');
            $ticket->updated_at = Carbon::now()->timezone('Europe/Paris');
            $ticket->closed_at = ($request->statut==4)?Carbon::now()->timezone('Europe/Paris'):null;
            $ticket->cri = 0;
            $ticket->cloture = ($request->statut==4)?1:0;
            list($hours, $minutes) = explode(':', $request->duree);
            $ticket->duree = (float)($hours . '.' . $minutes);
            $ticket->date_rappel = (isset($request->date_rappel))?$request->date_rappel:null;
            $ticket->action_cours = (isset($request->action_cours))?$request->action_cours:null;
            if(isset($request->forfait)){
                $ticket->id_forfait = $request->forfait;
            }
            $ticket->id_client = $request->client;
            $ticket->id_technicien = $request->technicien;
            $ticket->id_service = $request->service;
            $ticket->id_categorie = $request->categorie;
            $ticket->id_fonction = $request->fonction;
            $ticket->id_statut = $request->statut;
            $ticket->id_impact = $request->impact;
            $ticket->id_priorite = $request->priorite;
            $ticket->save();

            // Vérifiez si le ticket a été créé avec succès
            if ($ticket->exists) {
                // Créez une nouvelle ligne de ticket
                $ticketLigne = new TicketLigne();
                $ticketLigne->id_ticket = $ticket->id_ticket; // Associez la ligne au ticket
                $ticketLigne->text = $request->message;
                $ticketLigne->created_at = Carbon::now()->timezone('Europe/Paris');
                $ticketLigne->updated_at = Carbon::now()->timezone('Europe/Paris');
                $ticketLigne->type_user = 1;
                $ticketLigne->id_technicien = Technicien::getTechId();

                $ticketLigne->ct_num = $request->client;
                $ticketLigne->id_contact = $request->contact ?? null;
                $ticketLigne->save();
            }
            $data = [
                'titre' => $ticket->titre,
                'message' => $ticket->message,
                'statut' => $ticket->statut->libelle,
                't_nom' => $ticket->technicien->nom,
                't_prenom' => $ticket->technicien->prenom,
                'client' => $ticket->client->CT_Intitule,
                'contact' => $ticket->client->CT_Intitule,
                'date' => Carbon::now()->timezone('Europe/Paris')->translatedFormat('l d F Y H:i:s'),
                'service' => $ticket->service->libelle,
                'categorie' => $ticket->categorie->libelle,
                'fonction' => $ticket->fonction->libelle,
                'id' => $ticket->id_ticket
            ];
            if(isset($ticketLigne->contactCbmarq->CT_EMail) && $ticketLigne->contactCbmarq->CT_EMail != ""){
                Mail::to($ticketLigne->contactCbmarq->CT_EMail)->send(new PostMailOpen($data));
            }else{
                return redirect()->back()->with('warning', 'Le contact n\'a pas d\'adresse mail.');
            }

            // Retournez une réponse de succès
            return redirect()->route('ticket.edit', ['id' => $ticket->id_ticket])->with('success', 'Nouveau ticket ajouté avec succès!');
        } catch (\Exception $e) {
            // Retournez une réponse en cas d'erreur
            return redirect()->back()->with('error', 'Erreur lors de l\'ajout du ticket.'. $e);
        }
    }

    public function searchClients(Request $request)
    {
        $search = $request->input('search');
        // $clients = Client::where('CT_Num', 'LIKE', "%{$search}%")->get(['CT_Num','CT_Intitule']);
        $clients = Client::where('CT_Num', 'LIKE', "%{$search}%")
                     ->orWhere('CT_Intitule', 'LIKE', "%{$search}%")
                     ->get(['CT_Num', 'CT_Intitule']);

        return response()->json($clients);
    }

    public function getContacts($client_id)
    {
        $contacts = Contact::where('CT_Num', $client_id)->get(['CT_Num', 'CT_Nom', 'CT_Prenom', 'cbMarq']);
        return response()->json($contacts);
    }

    public function edit(Request $request, $id)
    {
        $ticket = Ticket::with('lignes')->findOrFail($id);
        $ticket->formatted_duree = TimeHelper::formatDuration($ticket->duree);
        $clients = Client::all();
        $techniciens = Technicien::all();
        $priorites = Priorite::all();
        $impacts = Impact::all();
        $status = Status::all();
        $fonctions = Fonction::all();
        $categories = Categorie::all();
        $services = Service::all();
        $risques = Risque::all();
        $forfaits = Forfait::all();

        return view('ticket.edit', compact('ticket', 'clients', 'techniciens', 'priorites', 'impacts', 'status', 'fonctions', 'categories', 'services', 'risques', 'forfaits'));
    }

    public function newMessage(Request $request){
        try{
            $request->validate([
                'message' => 'required|string|min:2',
            ]);
            $ticket = Ticket::findOrFail($request->id);
            // Vérifiez si le ticket a été créé avec succès
            if ($ticket->exists) {
                // Créez une nouvelle ligne de ticket
                $ticketLigne = new TicketLigne();
                $ticketLigne->id_ticket = $ticket->id_ticket; // Associez la ligne au ticket
                $ticketLigne->text = $request->message;
                $ticketLigne->created_at = Carbon::now()->timezone('Europe/Paris');
                $ticketLigne->updated_at = Carbon::now()->timezone('Europe/Paris');
                if($request->afficher == 1){
                    $type_user = 2;
                }else{
                    $type_user = 1;
                }
                $ticketLigne->type_user = $type_user;
                $ticketLigne->id_technicien = Technicien::getTechId();
                // Séparer les informations du contact
                $contactInfo = explode('-', $request->contact);
                $ticketLigne->ct_nom = $contactInfo[1] ?? '';
                $ticketLigne->ct_prenom = $contactInfo[2] ?? '';

                $ticketLigne->ct_num = $request->client;
                $ticketLigne->id_contact = $request->contact ?? null;
                $ticketLigne->save();
            }

            return redirect()->back()->with('success', 'Nouveau message ajouté avec succès!');
        } catch (\Exception $e) {
            // Retournez une réponse en cas d'erreur
            return redirect()->back()->with('error', 'Erreur lors de l\'ajout du message.');
        }
    }

    public function editPost(Request $request){
        try{
            // Validez les données du formulaire
            $request->validate([
                'client' => 'required|exists:sqlsrv2.F_COMPTET,CT_Num',
                'technicien' => 'required|exists:techniciens,id_technicien',
                'service' => 'required|exists:services,id_service',
                'fonction' => 'required|exists:Fonctions,id_fonction',
                'categorie' => 'required|exists:Categories,id_categorie',
                'statut' => 'required|exists:Status,id_statut',
                'priorite' => 'required|exists:priorite,id_priorite',
                'impact' => 'required|exists:impact,id_impact',
            ]);
            $ticket = Ticket::findOrFail($request->id);
            if ($ticket->exists) {
                $old_statut = $ticket->id_statut;
                $ticket->updated_at = Carbon::now()->timezone('Europe/Paris');
                $ticket->closed_at = ($request->statut==4)?Carbon::now()->timezone('Europe/Paris'):null;
                $ticket->cri = (isset($request->cri))?$request->cri:0;
                $ticket->cloture = ($request->statut==4)?1:0;
                list($hours, $minutes) = explode(':', $request->duree);
                $ticket->duree = (float)($hours . '.' . $minutes);
                $ticket->date_rappel = (isset($request->date_rappel))?$request->date_rappel:null;
                $ticket->action_cours = (isset($request->action_cours))?$request->action_cours:null;
                if(isset($request->forfait) && $request->cri == 1){
                    $ticket->id_forfait = $request->forfait;
                }else{
                    $ticket->id_forfait = null;
                }
                $ticket->id_client = $request->client;
                $ticket->id_technicien = $request->technicien;
                $ticket->id_service = $request->service;
                $ticket->id_categorie = $request->categorie;
                $ticket->id_fonction = $request->fonction;
                $ticket->id_statut = $request->statut;
                $ticket->id_impact = $request->impact;
                $ticket->id_priorite = $request->priorite;
                $ticket->save();
            }
            $ticketLigne = $ticket->lignes->first();
            $data = [
                'titre' => $ticket->titre,
                'statut' => $ticket->statut->libelle,
                't_nom' => $ticket->technicien->nom,
                't_prenom' => $ticket->technicien->prenom,
                'contact' => $ticket->client->CT_Intitule,
                'date' => Carbon::now()->timezone('Europe/Paris')->translatedFormat('l d F Y H:i'),
                'service' => $ticket->service->libelle,
                'categorie' => $ticket->categorie->libelle,
                'fonction' => $ticket->fonction->libelle,
                'id' => $ticket->id_ticket
            ];
            if(isset($ticketLigne->contactCbmarq->CT_EMail) && $ticketLigne->contactCbmarq->CT_EMail != ""){
                if($ticket->cloture == 1){
                    Mail::to($ticketLigne->contactCbmarq->CT_EMail)->send(new PostMailClose($data));
                }else{
                    if($ticket->cloture != 1 && $ticket->id_statut != 1){
                        if($request->statut != $old_statut){
                            Mail::to($ticketLigne->contactCbmarq->CT_EMail)->send(new PostMailUpdate($data));
                        }

                    }
                }
            }else{
                return redirect()->back()->with('warning', 'Le contact n\'a pas d\'adresse mail.');
            }

            return redirect()->back()->with('success', 'Edition du ticket '.$ticket->id_ticket.' avec succès!');
        } catch (\Exception $e) {
            // Retournez une réponse en cas d'erreur
            return redirect()->back()->with('error', 'Erreur lors de l\'ajout du message.'. $e);
        }
    }

    public function getRemainingCredit($forfaitId)
    {
        $forfait = Forfait::find($forfaitId);

        if ($forfait) {
            $remainingCredit = $forfait->restant();
            return response()->json(['remainingCredit' => $remainingCredit]);
        } else {
            return response()->json(['error' => 'Forfait non trouvé'], 404);
        }
    }

    public function getContactsTab($client_id)
    {
        // Récupérer les contacts du client avec l'ID spécifié
        $contacts = Contact::where('CT_Num', $client_id)->get();
        // Encoder toutes les données en UTF-8
        $contacts = $contacts->map(function ($contact) {
            return collect($contact)->map(function ($value) {
                return mb_convert_encoding($value, 'UTF-8', 'UTF-8');
            });
        });
        // Retourner les contacts sous forme de réponse JSON
        return response()->json(['contacts' => $contacts]);
    }

    public function getClientTab($client_id)
    {
        // Récupérer les client du client avec l'ID spécifié
        $client = Client::with('collaborateur')->findOrFail($client_id);
        // Encoder manuellement chaque champ du client et du collaborateur en UTF-8
        $clientData = collect($client)->map(function ($value) {
            return mb_convert_encoding($value, 'UTF-8', 'UTF-8');
        })->toArray();

        // Si le client a un collaborateur, encoder également ses champs
        if ($client->collaborateur) {
            $clientData['collaborateur'] = collect($client->collaborateur)->map(function ($value) {
                return mb_convert_encoding($value, 'UTF-8', 'UTF-8');
            })->toArray();
        }
        // Retourner les client sous forme de réponse JSON
        return response()->json(['client' => $clientData]);
    }

    public function callClient($id)
    {
        try{
            $ticket = Ticket::findOrFail($id);
            // Vérifiez si le ticket a été créé avec succès
            if ($ticket->exists) {
                $ticketLigne = $ticket->lignes()->orderBy('created_at', 'asc')->first();
                if(isset($ticketLigne->contactCbmarq->CT_EMail) && $ticketLigne->contactCbmarq->CT_EMail != ""){
                    // Créez une nouvelle ligne de ticket
                    $ticketLigne = new TicketLigne();
                    $ticketLigne->id_ticket = $ticket->id_ticket; // Associez la ligne au ticket
                    $ticketLigne->text = "Nos équipes ont tenté de prendre contact avec vous.";
                    $ticketLigne->created_at = Carbon::now()->timezone('Europe/Paris');
                    $ticketLigne->updated_at = Carbon::now()->timezone('Europe/Paris');
                    $ticketLigne->type_user = 1;
                    $ticketLigne->id_technicien = Technicien::getTechId();
                    $ticketLigne->ct_num = $ticket->id_client;
                    $ticketLigne->save();

                    $data = [
                        'titre' => $ticket->titre,
                        'statut' => $ticket->statut->libelle,
                        't_nom' => technicien::find(Technicien::getTechId())->nom,
                        't_prenom' => technicien::find(Technicien::getTechId())->prenom,
                        'client' => $ticket->client->CT_Intitule,
                        'contact' => $ticket->client->CT_Intitule,
                        'date' => Carbon::now()->timezone('Europe/Paris')->translatedFormat('l d F Y H:i'),
                        'date_ticket' => Carbon::parse($ticket->created_at)->translatedFormat('l d F Y H:i'),
                        'service' => $ticket->service->libelle,
                        'categorie' => $ticket->categorie->libelle,
                        'fonction' => $ticket->fonction->libelle,
                        'id' => $ticket->id_ticket
                    ];
                    Mail::to($ticketLigne->contactCbmarq->CT_EMail)->send(new PostMailContact($data));
                }else{
                    return redirect()->back()->with('warning', 'Le contact n\'a pas d\'adresse mail.');
                }

            }

            return redirect()->back()->with('success', 'Tentative de contact avec succès!');
        } catch (\Exception $e) {
            // Retournez une réponse en cas d'erreur
            return redirect()->back()->with('error', 'Erreur lors de le l\'envoie du mail.');
        }
    }

    public function editContact($idticket, $idcontact)
    {
        $ticket = Ticket::findOrFail($idticket);
        $contact = Contact::where('cbMarq', $idcontact)->firstOrFail();


        return view('ticket.contact.editContact', compact('ticket', 'contact'));
    }

    public function editContactPost(Request $request)
    {
        try{
            $ticket = Ticket::findOrFail($request->id);
            $contact = Contact::where('cbMarq', $request->id_contact)->firstOrFail();

            $contact->CT_Nom = $request->nom;
            $contact->CT_Prenom = $request->prenom;
            $contact->CT_Fonction = $request->fonction;
            $contact->CT_Telephone = $request->telephone;
            $contact->CT_TelPortable = $request->portable;
            $contact->CT_EMail = $request->email;
            $contact->save();

            return redirect()->route('ticket.edit', ['id' => $ticket->id_ticket])->with('success', 'Edition du contact '. $request->nom .' '. $request->prenom .' avec succès!');
        } catch (\Exception $e) {
            // Retournez une réponse en cas d'erreur
            return redirect()->back()->with('error', 'Erreur lors de l\'édition du contact.');
        }
    }

    public function createContact($idticket)
    {
        $ticket = Ticket::findOrFail($idticket);

        return view('ticket.contact.createContact', compact('ticket'));
    }

    public function createContactNoId()
    {
        return view('ticket.contact.createContactNoId');
    }

    public function createContactPost(Request $request)
    {
        try{
            // Validation des données
            $validatedData = $request->validate([
                'nom' => 'required|string',
                'prenom' => 'required|string',
                'fonction' => 'nullable|string',
                'telephone' => 'nullable',
                'portable' => 'nullable',
                'email' => 'nullable|email',
            ]);
            $ticket = Ticket::findOrFail($request->id);
            $maxCbMarq = Contact::max('cbMarq');

            $contact = new Contact();
            $contact->CT_Num = $ticket->id_client;
            $contact->CT_Nom = $validatedData['nom'];
            $contact->CT_Prenom = $validatedData['prenom'];
            $contact->CT_Fonction = $validatedData['fonction'];
            $contact->CT_Telephone = $validatedData['telephone'];
            $contact->CT_TelPortable = $validatedData['portable'];
            $contact->CT_EMail = $validatedData['email'];

            $contact->save();

            return redirect()->route('ticket.edit', ['id' => $ticket->id_ticket])->with('success', 'Création du contact '. $request->nom .' '. $request->prenom .' avec succès!');
        } catch (\Exception $e) {
            // Retournez une réponse en cas d'erreur
            return redirect()->back()->with('error', 'Erreur lors de la création du contact.');
        }
    }

    public function createContactPostNoId(Request $request)
    {
        try{
            // Validation des données
            $validatedData = $request->validate([
                'client' => 'required|exists:sqlsrv2.F_COMPTET,CT_Num',
                'nom' => 'required|string',
                'prenom' => 'required|string',
                'fonction' => 'nullable|string',
                'telephone' => 'nullable',
                'portable' => 'nullable',
                'email' => 'nullable|email',
            ]);

            $contact = new Contact();
            $contact->CT_Num = $validatedData['client'];
            $contact->CT_Nom = $validatedData['nom'];
            $contact->CT_Prenom = $validatedData['prenom'];
            $contact->CT_Fonction = $validatedData['fonction'];
            $contact->CT_Telephone = $validatedData['telephone'];
            $contact->CT_TelPortable = $validatedData['portable'];
            $contact->CT_EMail = $validatedData['email'];

            $contact->save();

            return redirect()->route('create')->with('success', 'Création du contact '. $request->nom .' '. $request->prenom .' avec succès!');
        } catch (\Exception $e) {
            // Retournez une réponse en cas d'erreur
            return redirect()->back()->with('error', 'Erreur lors de la création du contact.');
        }
    }

}
