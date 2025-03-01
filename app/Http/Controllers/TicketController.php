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
use App\Mail\PostMailOpen;
use App\Models\Abonnement;
use App\Models\Technicien;
use App\Helpers\TimeHelper;
use App\Mail\PostMailClose;
use App\Models\TicketLigne;
use App\Mail\PostMailUpdate;
use Illuminate\Http\Request;
use App\Mail\PostMailContact;
use App\Helpers\FunctionHelper;
use App\Models\AbonnementLigne;
use Illuminate\Support\Facades\Mail;

class TicketController extends Controller
{
    private function cleanHTML($text) {
        // Supprime tous les styles inline
        $text = preg_replace('/\s*style\s*=\s*"[^"]*"/i', '', $text);
        
        // Supprime toutes les classes
        $text = preg_replace('/\s*class\s*=\s*"[^"]*"/i', '', $text);
    
        // Supprime tous les attributs ngx et data
        $text = preg_replace('/\s*(_ng[^=]+|data-[^=]+)\s*=\s*"[^"]*"/i', '', $text);
        
        // Supprime les balises span vides
        $text = preg_replace('/<span[^>]*>([\s]*)<\/span>/i', '$1', $text);
        
        // Liste des balises autorisées
        $allowedTags = '<p><br><b><strong><i><em><u><ul><ol><li>';
        
        // Nettoie le HTML en ne gardant que les balises autorisées
        $text = strip_tags($text, $allowedTags);
        
        // Supprime les lignes vides multiples
        $text = preg_replace('/(\r?\n){2,}/', "\n\n", $text);
        
        return trim($text);
    }

    public function ticket(Request $request)
    {
        try {
            // Requête de base avec eager loading
            $query = Ticket::where('cloture', 0)
                ->with([
                    'client',
                    'statut',
                    'technicien',
                    'categorie',
                    'fonction',
                    'service',
                    'impact',
                    'priorite',
                    'premiereTicketLigne.contactCbmarq'
                ]);
    
            // Application des filtres
            if ($request->filled('ticket_id')) {
                $query->where('id_ticket', 'like', $request->input('ticket_id') . '%');
            }
    
            if ($request->filled('contact_id')) {
                $cbMarq = $request->input('contact_id');
                $query->whereHas('premiereTicketLigne', function($q) use ($cbMarq) {
                    $q->where('id_contact', $cbMarq);
                });
            }
    
            if ($request->filled('ticket_titre')) {
                $query->where('titre', 'like', '%' . $request->input('ticket_titre') . '%');
            }
    
            if ($request->filled('client_name')) {
                $query->where('id_client', 'like', '%' . $request->input('client_name') . '%');
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
    
            if ($request->filled('risque')) {
                $risque = $request->input('risque');
                $query->whereHas('impact', function($q) use ($risque) {
                    $q->whereHas('risques', function($q) use ($risque) {
                        $q->where('id_risque', $risque);
                    });
                });
            }
    
            // Récupération des données
            $tickets = $query->orderBy('created_at', 'desc')->paginate(50);
    
            // Récupération des données pour les filtres
            $risques = Risque::where(function($query) {
                $query->whereNull('masquer')
                      ->orWhere('masquer', 0);
            })->orderBy('libelle')->get();
    
            // Si c'est une requête AJAX
            if ($request->ajax()) {
                try {
                    $view = view('ticket.partials.tickets_table', compact('tickets', 'risques'))->render();
                    $pagination = view('ticket.partials.pagination', compact('tickets'))->render();
    
                    return response()->json([
                        'html' => $view,
                        'count' => $tickets->total(),
                        'pagination' => $pagination,
                        'hasChanges' => true
                    ]);
                } catch (\Exception $e) {                    
                    return response()->json([
                        'error' => 'Erreur lors du rendu des données',
                        'details' => $e->getMessage()
                    ], 500);
                }
            }
    
            // Pour le chargement initial de la page
            $statuts = Status::where('id_statut', '!=', 4)->orderBy('ordre_tri', 'asc')->get();
            $techniciens = Technicien::where(function($query) {
                $query->whereNull('masquer')
                      ->orWhere('masquer', 0);
            })->orderBy('nom')->orderBy('prenom')->get();
            
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
    
            return view('ticket.list', compact(
                'tickets',
                'statuts',
                'risques',
                'techniciens',
                'categories',
                'fonctions',
                'services'
            ));
    
        } catch (\Exception $e) {            
            if ($request->ajax()) {
                return response()->json([
                    'error' => 'Une erreur est survenue lors du chargement des tickets',
                    'details' => $e->getMessage()
                ], 500);
            }
            
            return back()->with('error', 'Une erreur est survenue lors du chargement des tickets');
        }
    }

    public function ticket_clots(Request $request)
    {
        try {
            $query = Ticket::where('cloture', 1)
                ->with([
                    'client',
                    'technicien',
                    'categorie',
                    'fonction',
                    'service',
                    'impact',
                    'priorite',
                    'premiereTicketLigne.contactCbmarq'
                ]);
    
            // Filtres
            if ($request->ticket_id) {
                $query->where('id_ticket', $request->ticket_id);
            }
    
            if ($request->ticket_titre) {
                $query->where('titre', 'LIKE', '%' . $request->ticket_titre . '%');
            }
    
            if ($request->client_name) {
                $query->whereHas('client', function($q) use ($request) {
                    $q->where('CT_Num', 'LIKE', '%' . $request->client_name . '%');
                });
            }
    
            if ($request->contact_id) {
                $query->whereHas('premiereTicketLigne', function($q) use ($request) {
                    $q->where('id_contact', $request->contact_id);
                });
            }
    
            if ($request->technicien) {
                $query->where('id_technicien', $request->technicien);
            }
    
            if ($request->risque) {
                $query->whereHas('risque', function($q) use ($request) {
                    $q->where('id_risque', $request->risque);
                });
            }
    
            if ($request->categorie) {
                $query->where('id_categorie', $request->categorie);
            }
    
            if ($request->fonction) {
                $query->where('id_fonction', $request->fonction);
            }
    
            if ($request->service) {
                $query->where('id_service', $request->service);
            }
    
            if ($request->date) {
                $query->whereDate('created_at', $request->date);
            }
    
            if ($request->date_clot) {
                $query->whereDate('closed_at', $request->date_clot);
            }
    
            if ($request->has('cri')) {
                $query->where('cri', $request->cri);
            }
    
            $tickets = $query->orderBy('created_at', 'desc')->paginate(50);
            $risques = Risque::all();
    
            if ($request->ajax()) {
                $view = view('ticket.partials.tickets_clots_table', compact('tickets', 'risques'))->render();
                
                return response()->json([
                    'html' => $view,
                    'count' => $tickets->total(),
                    'pagination' => view('ticket.partials.pagination', compact('tickets'))->render(),
                    'hasChanges' => true
                ]);
            }
    
            // Pour le chargement initial de la page
            $techniciens = Technicien::orderBy('nom')->get();
            $services = Service::orderBy('libelle')->get();
            $categories = Categorie::orderBy('libelle')->get();
            $fonctions = Fonction::orderBy('libelle')->get();
    
            return view('ticket.list_clots', compact(
                'tickets',
                'risques',
                'techniciens',
                'services',
                'categories',
                'fonctions'
            ));
    
        } catch (\Exception $e) {            
            if ($request->ajax()) {
                return response()->json([
                    'error' => 'Une erreur est survenue lors du chargement des tickets',
                    'details' => $e->getMessage()
                ], 500);
            }
            
            return back()->with('error', 'Une erreur est survenue lors du chargement des tickets');
        }
    }

    public function createVue()
    {
        $clients = Client::all();
        $techniciens = Technicien::orderBy('nom', 'asc')->orderBy('prenom', 'asc')->get();
        $priorites = Priorite::all();
        $impacts = Impact::all();
        $status = Status::where('id_statut', 1)->get();
        $fonctions = Fonction::orderBy('libelle', 'asc')->get();
        $categories = Categorie::orderBy('libelle', 'asc')->get();
        $services = Service::orderBy('libelle', 'asc')->get();

        return view('ticket.create', compact('clients', 'techniciens', 'priorites', 'impacts', 'status', 'fonctions', 'categories', 'services'));
    }

    public function create(Request $request)
    {
        try {
            // Validez les données du formulaire
            $request->validate([
                'titre' => 'required|string|max:255',
                'client' => 'required|exists:sqlsrv2.F_COMPTET,CT_Num',
                'technicien' => 'nullable|exists:techniciens,id_technicien',
                'service' => 'required|exists:services,id_service',
                'fonction' => 'required|exists:Fonctions,id_fonction',
                'categorie' => 'required|exists:Categories,id_categorie',
                'statut' => 'required|exists:Status,id_statut',
                'priorite' => 'required|exists:priorite,id_priorite',
                'impact' => 'nullable|exists:impact,id_impact',
            ]);
            // Créez un nouvel objet Forfait avec les données validées
            $ticket = new Ticket();
            $ticket->titre = $request->titre;
            $ticket->created_at = Carbon::now()->timezone('Europe/Paris');
            $ticket->updated_at = Carbon::now()->timezone('Europe/Paris');
            $ticket->closed_at = ($request->statut==4)?Carbon::now()->timezone('Europe/Paris'):null;
            $ticket->cri = 0;
            $ticket->cloture = ($request->statut==4)?1:0;
            $ticket->date_rappel = (isset($request->date_rappel))?$request->date_rappel:null;
            $ticket->action_cours = (isset($request->action_cours))?$request->action_cours:null;
            if(isset($request->forfait)){
                $ticket->id_forfait = $request->forfait;
            }
            $ticket->id_client = $request->client;
            $ticket->id_technicien = (isset($request->technicien))?$request->technicien:null;
            $ticket->id_service = $request->service;
            $ticket->id_categorie = $request->categorie;
            $ticket->id_fonction = $request->fonction;
            $ticket->id_statut = $request->statut;
            $ticket->id_impact = $request->impact ? $request->impact : 1;
            $ticket->id_priorite = $request->priorite;
            $ticket->save();

            // Vérifiez si le ticket a été créé avec succès
            if ($ticket->exists) {
                // Créez une nouvelle ligne de ticket
                $ticketLigne = new TicketLigne();
                $ticketLigne->id_ticket = $ticket->id_ticket; // Associez la ligne au ticket
                // Nettoyage du texte avant sauvegarde
                $cleanedMessage = $this->cleanHTML($request->message);
                $ticketLigne->text = wordwrap($cleanedMessage, 40, "\n", true);
                $ticketLigne->created_at = Carbon::now()->timezone('Europe/Paris');
                $ticketLigne->updated_at = Carbon::now()->timezone('Europe/Paris');
                $ticketLigne->type_user = 1;
                $ticketLigne->id_technicien = Technicien::getTechId();

                $ticketLigne->ct_num = $request->client;
                $ticketLigne->id_contact = $request->contact ?? null;
                if($request->duree == "00:00"){
                    $tempsTicket = "00:01";
                }else{
                    $tempsTicket = $request->duree;
                }
                list($hours, $minutes) = explode(':', $tempsTicket);
                $ticketLigne->duree = (float)($hours . '.' . $minutes);
                $timeLigne = TimeHelper::convertDureeToMinutes($ticketLigne->duree);
                $ticket->duree = TimeHelper::convertMinutesToDuration($timeLigne);

                $ticketLigne->save();
                $ticket->save();
            }
            $data = [
                'titre' => $ticket->titre,
                'message' => $ticket->message,
                'statut' => $ticket->statut->libelle,
                't_nom' => $ticket->technicien->nom ?? '',
                't_prenom' => $ticket->technicien->prenom ?? '',
                'client' => $ticket->client->CT_Intitule,
                'contact' => $ticket->client->CT_Intitule,
                'date' => Carbon::now()->timezone('Europe/Paris')->translatedFormat('l d F Y H:i:s'),
                'service' => $ticket->service->libelle,
                'categorie' => $ticket->categorie->libelle,
                'fonction' => $ticket->fonction->libelle,
                'id' => $ticket->id_ticket
            ];
            if(isset($ticketLigne->contactCbmarq->CT_EMail) && $ticketLigne->contactCbmarq->CT_EMail != ""){
                if(filter_var(trim($ticketLigne->contactCbmarq->CT_EMail), FILTER_VALIDATE_EMAIL) !== false){
                    Mail::to(trim($ticketLigne->contactCbmarq->CT_EMail))->send(new PostMailOpen($data));
                }else{
                    return redirect()->route('ticket.edit', ['id' => $ticket->id_ticket])->with('warning', 'Le contact n\'a pas une adresse mail valide.');
                }
            }else{
                return redirect()->route('ticket.edit', ['id' => $ticket->id_ticket])->with('warning', 'Le contact n\'a pas d\'adresse mail.');
            }

            // Retournez une réponse de succès
            return redirect()->route('ticket.edit', ['id' => $ticket->id_ticket])->with('success', 'Nouveau ticket ajouté avec succès!');
        } catch (\Exception $e) {
            // Retournez une réponse en cas d'erreur
            return redirect()->back()->with('error', 'Erreur lors de l\'ajout du ticket.'.$e->getmessage());
        }
    }

    public function searchClients(Request $request)
    {
        $search = $request->input('search');

        $clients = Client::where('CT_Num', 'LIKE', "%{$search}%")
        ->orWhere('CT_Intitule', 'LIKE', "%{$search}%")
        ->orderBy('CT_Intitule') // Tri par CT_Intitule en premier
        ->orderBy('CT_Num')      // Tri par CT_Num en second
        ->get(['CT_Num', 'CT_Intitule']);

        return response()->json($clients);
    }

    public function getAbonnementsByClient($clientId)
    {
        $abonnements = Abonnement::where('CT_Num', $clientId)
            ->with('lignes') // Charger les lignes associées
            ->get();

        // Convertir en UTF-8
        $abonnements = $abonnements->map(function ($item) {
            $itemArray = $item->toArray();
            $itemArray = array_map(function ($value) {
                return is_string($value) ? mb_convert_encoding($value, 'UTF-8', 'auto') : $value;
            }, $itemArray);

            // Encoder les lignes de l'abonnement
            $itemArray['lignes'] = array_map(function ($ligne) {
                return array_map(function ($value) {
                    return is_string($value) ? mb_convert_encoding($value, 'UTF-8', 'auto') : $value;
                }, $ligne);
            }, $itemArray['lignes']);

            return $itemArray;
        });

        return response()->json(['abonnements' => $abonnements]);
    }

    public function getContacts($client_id)
    {
        $contacts = Contact::where('CT_Num', $client_id)->orderBy('CT_Nom', 'asc')->orderBy('CT_Prenom', 'asc')->get(['CT_Num', 'CT_Nom', 'CT_Prenom', 'cbMarq']);
        return response()->json($contacts);
    }

    public function edit(Request $request, $id)
    {
        $ticket = Ticket::with('lignes')->findOrFail($id);
        $ticket->formatted_duree = TimeHelper::formatDuration($ticket->duree);
        $clients = Client::all();
        $techniciens = Technicien::orderBy('nom', 'asc')->orderBy('prenom', 'asc')->get();
        $priorites = Priorite::all();
        $impacts = Impact::all();
        $status = Status::orderBy('ordre_tri', 'asc')->get();
        $fonctions = Fonction::orderBy('libelle', 'asc')->get();
        $categories = Categorie::orderBy('libelle', 'asc')->get();
        $services = Service::orderBy('libelle', 'asc')->get();
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
                // Nettoyage du texte avant sauvegarde
                $cleanedMessage = $this->cleanHTML($request->message);
                $ticketLigne->text = wordwrap($cleanedMessage, 40, "\n", true);
                $ticketLigne->created_at = Carbon::now()->timezone('Europe/Paris');
                $ticketLigne->updated_at = Carbon::now()->timezone('Europe/Paris');
                $ticketLigne->type_user = $request->afficher == 1 ? 2 : 1;
                $ticketLigne->id_technicien = Technicien::getTechId();
                // Séparer les informations du contact
                $contactInfo = explode('-', $request->contact);
                $ticketLigne->ct_nom = $contactInfo[1] ?? '';
                $ticketLigne->ct_prenom = $contactInfo[2] ?? '';

                $ticketLigne->ct_num = $request->client;
                $ticketLigne->id_contact = $request->contact ?? null;


                $duree = $request->duree;

                // Vérifiez si la durée est bien au format HH:MM
                if (strpos($duree, ':') !== false) {
                    list($hours, $minutes) = explode(':', $duree);
                    $minutes = $minutes ?? '0'; // Utilisez '0' si la partie minutes n'est pas définie
                } else {
                    // Si le format est incorrect, définissez des valeurs par défaut
                    $hours = (int) $duree; // Par exemple, utilisez la durée entière pour les heures
                    $minutes = 0;
                }

                $ticketLigne->duree = (float)($hours . '.' . str_pad($minutes, 2, '0', STR_PAD_LEFT));
                $ticketLigne->duree = (float) $ticketLigne->duree;
                $ticket->duree = (float) $ticket->duree;


                $timeLigne = TimeHelper::convertDureeToMinutes((float)$ticketLigne->duree);
                $timeTicket = TimeHelper::convertDureeToMinutes((float)$ticket->duree);

                $totalMinutes = $timeLigne + $timeTicket;

                $ticket->duree = TimeHelper::convertMinutesToDuration($totalMinutes);

                $ticketLigne->save();
                $ticket->save();
            }

            return redirect()->back()->with('success', 'Nouveau message ajouté avec succès!');
        } catch (\Exception $e) {
            // Retournez une réponse en cas d'erreur
            return redirect()->back()->with('error', 'Erreur lors de l\'ajout du message.'.$e->getMessage());
        }
    }

    public function editPost(Request $request){
        try{
            // Validez les données du formulaire
            $request->validate([
                'client' => 'required|exists:sqlsrv2.F_COMPTET,CT_Num',
                'technicien' => 'nullable|exists:techniciens,id_technicien',
                'service' => 'required|exists:services,id_service',
                'fonction' => 'required|exists:Fonctions,id_fonction',
                'categorie' => 'required|exists:Categories,id_categorie',
                'statut' => 'required|exists:Status,id_statut',
                'priorite' => 'required|exists:priorite,id_priorite',
                'impact' => 'nullable|exists:impact,id_impact',
            ]);
            $ticket = Ticket::findOrFail($request->id);
            if ($ticket->exists) {
                $old_statut = $ticket->id_statut;
                $ticket->updated_at = Carbon::now()->timezone('Europe/Paris');
                $ticket->closed_at = ($request->statut==4)?Carbon::now()->timezone('Europe/Paris'):null;
                $ticket->cri = (isset($request->cri))?$request->cri:0;
                $ticket->cloture = ($request->statut==4)?1:0;
                list($hours, $minutes) = explode(':', $request->duree);
                if($request->statut==4){
                    if($request->technicien == null){
                        return redirect()->back()->with('warning', 'Le technicien est obligatoire pour clôturer.');
                        die();
                    }
                }
                $ticket->duree = (float)($hours . '.' . $minutes);
                $ticket->date_rappel = (isset($request->date_rappel))?$request->date_rappel:null;
                $ticket->action_cours = (isset($request->action_cours))?$request->action_cours:null;
                if(isset($request->forfait) && $request->cri == 1){
                    $ticket->id_forfait = $request->forfait;
                }else{
                    $ticket->id_forfait = null;
                }
                $ticket->id_client = $request->client;
                $ticket->id_technicien = (isset($request->technicien))?$request->technicien:null;
                $ticket->id_service = $request->service;
                $ticket->id_categorie = $request->categorie;
                $ticket->id_fonction = $request->fonction;
                $ticket->id_statut = $request->statut;
                $ticket->id_impact = $request->impact ? $request->impact : 1;
                $ticket->id_priorite = $request->priorite;
                $ticket->save();
            }
            $ticketLigne = $ticket->lignes->first();
            $ticketLigne->id_contact = $request->contact;
            $ticketLigne->save();
            $ticketLigne = $ticket->lignes->first();
            $data = [
                'titre' => $ticket->titre,
                'statut' => $ticket->statut->libelle,
                't_nom' => $ticket->technicien->nom ?? '',
                't_prenom' => $ticket->technicien->prenom ?? '',
                'contact' => $ticket->client->CT_Intitule,
                'date' => Carbon::now()->timezone('Europe/Paris')->translatedFormat('l d F Y H:i'),
                'service' => $ticket->service->libelle,
                'categorie' => $ticket->categorie->libelle,
                'fonction' => $ticket->fonction->libelle,
                'id' => $ticket->id_ticket
            ];
            if(isset($ticketLigne->contactCbmarq->CT_EMail) && $ticketLigne->contactCbmarq->CT_EMail != ""){
                if($ticket->cloture == 1){
                    if(filter_var(trim($ticketLigne->contactCbmarq->CT_EMail), FILTER_VALIDATE_EMAIL) !== false){
                        Mail::to(trim($ticketLigne->contactCbmarq->CT_EMail))->send(new PostMailClose($data));
                    }else{
                        return redirect()->back()->with('warning', 'Le contact n\'a pas une adresse mail valide.');
                    }
                }else{
                    if($ticket->cloture != 1 && $ticket->id_statut != 1){
                        if($request->statut != $old_statut){
                            if(filter_var(trim($ticketLigne->contactCbmarq->CT_EMail), FILTER_VALIDATE_EMAIL) !== false){
                                Mail::to(trim($ticketLigne->contactCbmarq->CT_EMail))->send(new PostMailUpdate($data));
                            }else{
                                return redirect()->back()->with('warning', 'Le contact n\'a pas une adresse mail valide.');
                            }
                        }
                    }
                }
            }else{
                return redirect()->back()->with('warning', 'Le contact n\'a pas d\'adresse mail.');
            }

            return redirect()->back()->with('success', 'Edition du ticket '.$ticket->id_ticket.' avec succès!');
        } catch (\Exception $e) {
            // Retournez une réponse en cas d'erreur
            return redirect()->back()->with('error', 'Erreur lors de l\'ajout du message.');
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
                    $email_contact = $ticketLigne->contactCbmarq->CT_EMail;

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

                    if(filter_var(trim($email_contact), FILTER_VALIDATE_EMAIL) !== false){
                        Mail::to(trim($email_contact))->send(new PostMailContact($data));
                    }else{
                        return redirect()->back()->with('warning', 'Le contact n\'a pas une adresse mail valide.');
                    }

                }else{
                    return redirect()->back()->with('warning', 'Le contact n\'a pas d\'adresse mail.');
                }
                return redirect()->back()->with('success', 'Tentative de contact avec succès! Mail envoyé à : '. $email_contact);
            }else{
                return redirect()->back()->with('warning', 'Le ticket n\'existe pas.');
            }
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

    public function decloture($id)
    {
        try {
            $ticket = Ticket::findOrFail($id);
            
            // Vérifier si le ticket est bien clôturé
            if ($ticket->cloture != 1) {
                return redirect()->back()->with('error', 'Ce ticket n\'est pas clôturé.');
            }
    
            // Mettre à jour le ticket
            $ticket->cloture = 0;
            $ticket->closed_at = null;
            $ticket->id_statut = 1; // Remettre le statut à "En attente"
            $ticket->save();
    
            // Ajouter une ligne dans l'historique du ticket
            $ticketLigne = new TicketLigne();
            $ticketLigne->id_ticket = $ticket->id_ticket;
            $ticketLigne->text = "Ticket déclôturé";
            $ticketLigne->created_at = Carbon::now()->timezone('Europe/Paris');
            $ticketLigne->updated_at = Carbon::now()->timezone('Europe/Paris');
            $ticketLigne->type_user = 2; // Type admin/système
            $ticketLigne->id_technicien = Technicien::getTechId(); // Utiliser la méthode statique
            $ticketLigne->save();
    
            return redirect()->back()->with('success', 'Le ticket a été déclôturé avec succès.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erreur lors de la déclôture du ticket : ' . $e->getMessage());
        }
    }

    public function updateMessage(Request $request, $id)
    {
        $ligne = TicketLigne::findOrFail($id);
        
        // Conversion des deux valeurs en entiers pour une comparaison cohérente
        if ((int)$ligne->id_technicien != (int)Technicien::getTechId()) {
            return redirect()->back()->with('error', 'Vous n\'êtes pas autorisé à modifier ce message');
        }
    
        if ($ligne->ticket->cloture == 1) {
            return redirect()->back()->with('error', 'Le ticket est clôturé');
        }
    
        $request->validate([
            'message' => 'required|string',
        ]);
    
        $ligne->text = $request->message;
        $ligne->save();
    
        return redirect()->back()->with('success', 'Message mis à jour avec succès');
    }

    public function getPreviousTickets($clientId)
    {
        $tickets = Ticket::where('id_client', $clientId)
                        ->with(['statut'])
                        ->orderBy('created_at', 'desc')
                        ->take(25)  // Limite aux 10 derniers tickets
                        ->get();

        return response()->json(['tickets' => $tickets]);
    }

    public function getForfaits($clientId)
    {
        $forfaits = Forfait::with('type')
            ->where('id_client', $clientId)
            ->where('masquer', null)
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($forfait) {
                // Convertir le crédit initial de minutes en format "Xh Ym"
                $creditInitialMinutes = $forfait->credit;
                $hours = intdiv($creditInitialMinutes, 60);
                $minutes = $creditInitialMinutes % 60;
                $forfait->credit_initial = sprintf('%dh %02dm', $hours, $minutes);
                
                // Crédit restant (utilise la méthode existante)
                $forfait->credit_restant = $forfait->restantEnHeures();
                
                // Formatage des dates
                $forfait->formatted_created_at = Carbon::parse($forfait->created_at)->format('d/m/Y');
                $forfait->formatted_valid_to = Carbon::parse($forfait->valid_to)->format('d/m/Y');
                
                return $forfait;
            });
    
        return response()->json(['forfaits' => $forfaits]);
    }

    public function getTicketsForfaits($clientId)
    {
        $tickets = Ticket::with(['forfait.type'])
            ->where('id_client', $clientId)
            ->where('cloture', 1) // Seulement les tickets clôturés
            ->whereNotNull('id_forfait')
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($ticket) {
                // Formatage de la durée en HH:mm
                $ticket->formatted_duree = TimeHelper::formatDuration($ticket->duree);
                return $ticket;
            });
    
        // Calcul du total des durées utilisées
        $totalMinutesUsed = $tickets->sum(function ($ticket) {
            return TimeHelper::convertDureeToMinutes($ticket->duree);
        });
    
        return response()->json([
            'tickets' => $tickets,
            'total_used' => TimeHelper::formatDuration(
                TimeHelper::convertMinutesToDuration($totalMinutesUsed)
            )
        ]);
    }
}
