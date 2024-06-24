<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Role;
use App\Models\Impact;
use App\Models\Risque;
use App\Models\Status;
use App\Models\Forfait;
use App\Models\Service;
use App\Models\Fonction;
use App\Models\Priorite;
use App\Models\Categorie;
use App\Models\Technicien;
use App\Models\TypeForfait;
use Illuminate\Http\Request;
use App\Mail\NotificationEmail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class ParamsController extends Controller
{
    public function home()
    {
        return view('params.home');
    }

    public function showStatusForm()
    {
        $statuses = Status::all(); // Récupérer tous les status depuis la base de données
        return view('params.form.status', compact('statuses'));
    }

    public function addStatus(Request $request)
    {
        try {
            // Validez les données de la requête
            $request->validate([
                'libelle' => 'required|string|max:50',
            ]);

            // Créez une nouvelle instance du modèle Status avec les données à ajouter
            $status = new Status();
            $status->libelle = $request->input('libelle');

            // Enregistrez les données dans la base de données
            $status->save();

            // Retournez une réponse de succès
            return redirect()->back()->with('success', 'Status ajouté avec succès!');
        } catch (\Exception $e) {
            // Retournez une réponse en cas d'erreur
            return redirect()->back()->with('error', 'Erreur lors de l\'ajout du statut.');
        }
    }

    public function modifierStatus($id)
    {
        $status = Status::findOrFail($id); // Récupérer le statut correspondant à l'ID fourni
        return view('params.form.statusEdit', compact('status'));
    }

    public function updateStatus(Request $request, $id)
    {
        $status = Status::findOrFail($id); // Récupérer le statut correspondant à l'ID fourni

        // Valider les données du formulaire
        $validatedData = $request->validate([
            'libelle' => 'required|string|max:50',
            // Autres règles de validation si nécessaire
        ]);

        // Mettre à jour les attributs du statut avec les données du formulaire
        $status->update($validatedData);

        // Rediriger avec un message de succès
        return redirect()->route('params.form.status')->with('success', 'Statut mis à jour avec succès.');
    }

    public function supprimerStatus($id)
    {
        $status = Status::findOrFail($id); // Récupérer le statut correspondant à l'ID fourni

        // Supprimer le statut
        $status->delete();

        // Rediriger avec un message de succès
        return redirect()->back()->with('success', 'Statut supprimé avec succès.');
    }


    public function showPrioriteForm()
    {
        $priorites = Priorite::all(); // Récupérer tous les status depuis la base de données
        return view('params.form.priorite', compact('priorites'));
    }

    public function addPriorite(Request $request)
    {
        try {
            // Validez les données de la requête
            $request->validate([
                'libelle' => 'required|string|max:50',
            ]);

            // Créez une nouvelle instance du modèle Status avec les données à ajouter
            $priorite = new Priorite();
            $priorite->libelle = $request->input('libelle');

            // Enregistrez les données dans la base de données
            $priorite->save();

            // Retournez une réponse de succès
            return redirect()->back()->with('success', 'Priorité ajouté avec succès!');
        } catch (\Exception $e) {
            // Retournez une réponse en cas d'erreur
            return redirect()->back()->with('error', 'Erreur lors de l\'ajout de la priorité.');
        }
    }

    public function modifierPriorite($id)
    {
        $priorite = Priorite::findOrFail($id); // Récupérer le statut correspondant à l'ID fourni
        return view('params.form.prioriteEdit', compact('priorite'));
    }

    public function updatePriorite(Request $request, $id)
    {
        $priorite = Priorite::findOrFail($id); // Récupérer le statut correspondant à l'ID fourni

        // Valider les données du formulaire
        $validatedData = $request->validate([
            'libelle' => 'required|string|max:50',
            // Autres règles de validation si nécessaire
        ]);

        // Mettre à jour les attributs du statut avec les données du formulaire
        $priorite->update($validatedData);

        // Rediriger avec un message de succès
        return redirect()->route('params.form.priorite')->with('success', 'Prioritée mise à jour avec succès.');
    }

    public function supprimerPriorite($id)
    {
        $priorite = Priorite::findOrFail($id); // Récupérer le statut correspondant à l'ID fourni

        // Supprimer le statut
        $priorite->delete();

        // Rediriger avec un message de succès
        return redirect()->back()->with('success', 'Prioritée supprimé avec succès.');
    }



    public function showImpactForm()
    {
        $impacts = Impact::all(); // Récupérer tous les status depuis la base de données
        return view('params.form.impact', compact('impacts'));
    }

    public function addImpact(Request $request)
    {
        try {
            // Validez les données de la requête
            $request->validate([
                'libelle' => 'required|string|max:50',
            ]);

            // Créez une nouvelle instance du modèle Status avec les données à ajouter
            $impact = new Impact();
            $impact->libelle = $request->input('libelle');

            // Enregistrez les données dans la base de données
            $impact->save();

            // Retournez une réponse de succès
            return redirect()->back()->with('success', 'Impact ajouté avec succès!');
        } catch (\Exception $e) {
            // Retournez une réponse en cas d'erreur
            return redirect()->back()->with('error', 'Erreur lors de l\'ajout de l\'impact.');
        }
    }

    public function modifierImpact($id)
    {
        $impact = Impact::findOrFail($id); // Récupérer le statut correspondant à l'ID fourni
        return view('params.form.impactEdit', compact('impact'));
    }

    public function updateImpact(Request $request, $id)
    {
        $impact = Impact::findOrFail($id); // Récupérer le statut correspondant à l'ID fourni

        // Valider les données du formulaire
        $validatedData = $request->validate([
            'libelle' => 'required|string|max:50',
            // Autres règles de validation si nécessaire
        ]);

        // Mettre à jour les attributs du statut avec les données du formulaire
        $impact->update($validatedData);

        // Rediriger avec un message de succès
        return redirect()->route('params.form.impact')->with('success', 'Impact mise à jour avec succès.');
    }

    public function supprimerImpact($id)
    {
        $impact = Impact::findOrFail($id); // Récupérer le statut correspondant à l'ID fourni

        // Supprimer le statut
        $impact->delete();

        // Rediriger avec un message de succès
        return redirect()->back()->with('success', 'Impact supprimé avec succès.');
    }


    public function showServiceForm()
    {
        $services = Service::all(); // Récupérer tous les status depuis la base de données
        return view('params.form.service', compact('services'));
    }

    public function addService(Request $request)
    {
        try {
            // Validez les données de la requête
            $request->validate([
                'libelle' => 'required|string|max:50',
            ]);

            // Créez une nouvelle instance du modèle Status avec les données à ajouter
            $service = new Service();
            $service->libelle = $request->input('libelle');

            // Enregistrez les données dans la base de données
            $service->save();

            // Retournez une réponse de succès
            return redirect()->back()->with('success', 'Service ajouté avec succès!');
        } catch (\Exception $e) {
            // Retournez une réponse en cas d'erreur
            return redirect()->back()->with('error', 'Erreur lors de l\'ajout du service.');
        }
    }

    public function modifierService($id)
    {
        $service = Service::findOrFail($id); // Récupérer le statut correspondant à l'ID fourni
        return view('params.form.serviceEdit', compact('service'));
    }

    public function updateService(Request $request, $id)
    {
        $service = Service::findOrFail($id); // Récupérer le statut correspondant à l'ID fourni

        // Valider les données du formulaire
        $validatedData = $request->validate([
            'libelle' => 'required|string|max:50',
            // Autres règles de validation si nécessaire
        ]);

        // Mettre à jour les attributs du statut avec les données du formulaire
        $service->update($validatedData);

        // Rediriger avec un message de succès
        return redirect()->route('params.form.service')->with('success', 'Service mise à jour avec succès.');
    }

    public function supprimerService($id)
    {
        $service = Service::findOrFail($id); // Récupérer le statut correspondant à l'ID fourni

        // Supprimer le statut
        $service->delete();

        // Rediriger avec un message de succès
        return redirect()->back()->with('success', 'Service supprimé avec succès.');
    }



    public function showCategorieForm()
    {
        $categories = Categorie::all(); // Récupérer tous les status depuis la base de données
        $services = Service::all();
        return view('params.form.categorie', compact('categories', 'services'));
    }

    public function addCategorie(Request $request)
    {
        try {
            // Validez les données de la requête
            $request->validate([
                'libelle' => 'required|string|max:50',
                'service_id' => 'required|exists:services,id_service',
            ]);
            // Créez une nouvelle instance du modèle Status avec les données à ajouter
            $categorie = new Categorie();
            $categorie->libelle = $request->input('libelle');
            $categorie->id_service = $request->input('service_id');

            // Enregistrez les données dans la base de données
            $categorie->save();

            // Retournez une réponse de succès
            return redirect()->back()->with('success', 'Catégorie ajouté avec succès!');
        } catch (\Exception $e) {
            // Retournez une réponse en cas d'erreur
            return redirect()->back()->with('error', 'Erreur lors de l\'ajout de la catégorie.');
        }
    }

    public function modifierCategorie($id)
    {
        $categorie = Categorie::findOrFail($id); // Récupérer le statut correspondant à l'ID fourni
        $services = Service::all();
        return view('params.form.categorieEdit', compact('categorie', 'services'));
    }

    public function updateCategorie(Request $request, $id)
    {
        $categorie = Categorie::findOrFail($id); // Récupérer le statut correspondant à l'ID fourni
        // Assurez-vous que le service existe avant de l'assigner à la catégorie
        $service = Service::findOrFail($request->input('id_service'));

        // Mettre à jour les autres attributs de la catégorie
        $categorie->libelle = $request->input('libelle');
        // Assigner l'ID du service à la catégorie
        $categorie->id_service = $service->id_service;
        // Sauvegarder la catégorie mise à jour
        $categorie->save();

        // Rediriger avec un message de succès
        return redirect()->route('params.form.categorie')->with('success', 'Catégorie mise à jour avec succès.');
    }

    public function supprimerCategorie($id)
    {
        $categorie = Categorie::findOrFail($id); // Récupérer le statut correspondant à l'ID fourni

        // Supprimer le statut
        $categorie->delete();

        // Rediriger avec un message de succès
        return redirect()->back()->with('success', 'Catégorie supprimé avec succès.');
    }


    public function showFonctionForm()
    {
        $fonctions = Fonction::all(); // Récupérer tous les status depuis la base de données
        $categories = Categorie::all();
        return view('params.form.fonction', compact('fonctions', 'categories'));
    }

    public function addFonction(Request $request)
    {
        try {
            // Validez les données de la requête
            $request->validate([
                'libelle' => 'required|string|max:50',
                'categorie_id' => 'required|exists:categories,id_categorie',
            ]);
            // Créez une nouvelle instance du modèle Status avec les données à ajouter
            $fonction = new Fonction();
            $fonction->libelle = $request->input('libelle');
            $fonction->id_categorie = $request->input('categorie_id');

            // Enregistrez les données dans la base de données
            $fonction->save();

            // Retournez une réponse de succès
            return redirect()->back()->with('success', 'Fonction ajouté avec succès!');
        } catch (\Exception $e) {
            // Retournez une réponse en cas d'erreur
            return redirect()->back()->with('error', 'Erreur lors de l\'ajout de la fonction.');
        }
    }

    public function modifierFonction($id)
    {
        $fonction = Fonction::findOrFail($id); // Récupérer le statut correspondant à l'ID fourni
        $categories = Categorie::all();
        return view('params.form.fonctionEdit', compact('fonction', 'categories'));
    }

    public function updateFonction(Request $request, $id)
    {
        try{
            $fonction = Fonction::findOrFail($id); // Récupérer le statut correspondant à l'ID fourni
            // Assurez-vous que le service existe avant de l'assigner à la catégorie
            $categorie = Categorie::findOrFail($request->input('id_categorie'));

            // Mettre à jour les autres attributs de la catégorie
            $fonction->libelle = $request->input('libelle');
            // Assigner l'ID du service à la catégorie
            $fonction->id_categorie = $categorie->id_categorie;
            // Sauvegarder la catégorie mise à jour
            $fonction->save();

            // Rediriger avec un message de succès
            return redirect()->route('params.form.fonction')->with('success', 'Fonction mise à jour avec succès.');
        } catch (\Exception $e) {
            // Retournez une réponse en cas d'erreur
            return redirect()->back()->with('error', 'Erreur lors de la modification de la fonction.');
        }
    }

    public function supprimerFonction($id)
    {
        try{
            $fonction = Fonction::findOrFail($id); // Récupérer le statut correspondant à l'ID fourni

            // Supprimer le statut
            $fonction->delete();

            // Rediriger avec un message de succès
            return redirect()->back()->with('success', 'Fonction supprimé avec succès.');
        } catch (\Exception $e) {
            // Retournez une réponse en cas d'erreur
            return redirect()->back()->with('error', 'Erreur lors de la suppresion de la fonction.');
        }
    }

    public function showRisqueForm()
    {
        $risques = Risque::all(); // Récupérer tous les status depuis la base de données
        $impacts = Impact::all();
        $priorites = Priorite::all();
        return view('params.form.risque', compact('risques', 'impacts', 'priorites'));
    }

    public function addRisque(Request $request)
    {
        try {
            // Validez les données de la requête
            $request->validate([
                'libelle' => 'required|string|max:50',
                'icon' => 'required|string',
                'impact_id' => 'required|exists:impact,id_impact',
                'priorite_id' => 'required|exists:priorite,id_priorite',
            ]);
            // Créez une nouvelle instance du modèle Status avec les données à ajouter
            $risque = new Risque();
            $risque->libelle = $request->input('libelle');
            $risque->icon = $request->input('icon');
            $risque->fond = $request->input('fond');
            $risque->id_impact = $request->input('impact_id');
            $risque->id_priorite = $request->input('priorite_id');
            // Enregistrez les données dans la base de données
            $risque->save();

            // Retournez une réponse de succès
            return redirect()->back()->with('success', 'Risque ajouté avec succès!');
        } catch (\Exception $e) {
            // Retournez une réponse en cas d'erreur
            return redirect()->back()->with('error', 'Erreur lors de l\'ajout du risque.');
        }
    }

    public function modifierRisque($id)
    {
        $risque = Risque::findOrFail($id); // Récupérer le statut correspondant à l'ID
        $impacts = Impact::all();
        $priorites = Priorite::all();
        return view('params.form.risqueEdit', compact('risque', 'impacts', 'priorites'));
    }

    public function updateRisque(Request $request, $id)
    {
        try {
            $risque = Risque::findOrFail($id); // Récupérer le statut correspondant à l'ID fourni
            // Assurez-vous que le service existe avant de l'assigner à la catégorie
            $impact = Impact::findOrFail($request->input('id_impact'));
            $priorite = Priorite::findOrFail($request->input('id_priorite'));
            // Validez les données de la requête
            $request->validate([
                'libelle' => 'required|string|max:50',
                'icon' => 'required|string',
            ]);
            // Mettre à jour les autres attributs de la catégorie
            $risque->libelle = $request->input('libelle');
            $risque->icon = $request->input('icon');
            $risque->fond = $request->fond;
            // Assigner l'ID du service à la catégorie
            $risque->id_impact = $impact->id_impact;
            $risque->id_priorite = $priorite->id_priorite;
            // Sauvegarder la catégorie mise à jour
            $risque->save();

            // Rediriger avec un message de succès
            return redirect()->route('params.form.risque')->with('success', 'Risque mise à jour avec succès.');
        } catch (\Exception $e) {
            // Retournez une réponse en cas d'erreur
            return redirect()->back()->with('error', 'Erreur lors de la modification du risque.'.$e);
        }
    }

    public function supprimerRisque($id)
    {
        try {
            $risque = Risque::findOrFail($id); // Récupérer le statut correspondant à l'ID fourni

            // Supprimer le statut
            $risque->delete();

            // Rediriger avec un message de succès
            return redirect()->back()->with('success', 'Risque supprimé avec succès.');
        } catch (\Exception $e) {
            // Retournez une réponse en cas d'erreur
            return redirect()->back()->with('error', 'Erreur lors de la suppresion du risque.');
        }
    }


    public function showRoleForm()
    {
        $roles = Role::all(); // Récupérer tous les status depuis la base de données
        return view('params.form.role', compact('roles'));
    }

    public function addRole(Request $request)
    {
        try {
            // Validez les données de la requête
            $request->validate([
                'libelle' => 'required|string|max:50',
            ]);

            // Créez une nouvelle instance du modèle Status avec les données à ajouter
            $role = new Role();
            $role->libelle = $request->input('libelle');

            // Enregistrez les données dans la base de données
            $role->save();

            // Retournez une réponse de succès
            return redirect()->back()->with('success', 'Role ajouté avec succès!');
        } catch (\Exception $e) {
            // Retournez une réponse en cas d'erreur
            return redirect()->back()->with('error', 'Erreur lors de l\'ajout du Role.');
        }
    }

    public function modifierRole($id)
    {
        $role = Role::findOrFail($id); // Récupérer le statut correspondant à l'ID fourni
        return view('params.form.roleEdit', compact('role'));
    }

    public function updateRole(Request $request, $id)
    {
        try{
            $role = Role::findOrFail($id); // Récupérer le statut correspondant à l'ID fourni

            // Valider les données du formulaire
            $validatedData = $request->validate([
                'libelle' => 'required|string|max:50',
                // Autres règles de validation si nécessaire
            ]);

            // Mettre à jour les attributs du statut avec les données du formulaire
            $role->update($validatedData);

            // Rediriger avec un message de succès
            return redirect()->route('params.form.role')->with('success', 'Role mise à jour avec succès.');
        } catch (\Exception $e) {
            // Retournez une réponse en cas d'erreur
            return redirect()->back()->with('error', 'Erreur lors de la modification du Role.');
        }
    }

    public function supprimerRole($id)
    {
        try{
            $role = Role::findOrFail($id); // Récupérer le statut correspondant à l'ID fourni

            // Supprimer le statut
            $role->delete();

            // Rediriger avec un message de succès
            return redirect()->back()->with('success', 'Role supprimé avec succès.');
        } catch (\Exception $e) {
            // Retournez une réponse en cas d'erreur
            return redirect()->back()->with('error', 'Erreur lors de la suppression du Role.');
        }
    }

    public function showTypeForfaitForm()
    {
        $typeForfaits = TypeForfait::all(); // Récupérer tous les status depuis la base de données
        return view('params.form.typeForfait', compact('typeForfaits'));
    }

    public function addTypeForfait(Request $request)
    {
        try {
            // Validez les données de la requête
            $request->validate([
                'libelle' => 'required|string|max:50',
            ]);

            // Créez une nouvelle instance du modèle Status avec les données à ajouter
            $typeForfait = new TypeForfait();
            $typeForfait->libelle = $request->input('libelle');

            // Enregistrez les données dans la base de données
            $typeForfait->save();

            // Retournez une réponse de succès
            return redirect()->back()->with('success', 'Type de forfait ajouté avec succès!');
        } catch (\Exception $e) {
            // Retournez une réponse en cas d'erreur
            return redirect()->back()->with('error', 'Erreur lors de l\'ajout du Type de forfait.');
        }
    }

    public function modifierTypeForfait($id)
    {
        $typeForfait = TypeForfait::findOrFail($id); // Récupérer le statut correspondant à l'ID fourni
        return view('params.form.typeForfaitEdit', compact('typeForfait'));
    }

    public function updateTypeForfait(Request $request, $id)
    {
        try{
            $typeForfait = TypeForfait::findOrFail($id); // Récupérer le statut correspondant à l'ID fourni

            // Valider les données du formulaire
            $validatedData = $request->validate([
                'libelle' => 'required|string|max:50',
                // Autres règles de validation si nécessaire
            ]);

            // Mettre à jour les attributs du statut avec les données du formulaire
            $typeForfait->update($validatedData);

            // Rediriger avec un message de succès
            return redirect()->route('params.form.typeForfait')->with('success', 'Type de forfait mise à jour avec succès.');
        } catch (\Exception $e) {
            // Retournez une réponse en cas d'erreur
            return redirect()->back()->with('error', 'Erreur lors de la modification du type de forfait.');
        }
    }

    public function supprimerTypeForfait($id)
    {
        try{
            $typeForfait = TypeForfait::findOrFail($id); // Récupérer le statut correspondant à l'ID fourni

            // Supprimer le statut
            $typeForfait->delete();

            // Rediriger avec un message de succès
            return redirect()->back()->with('success', 'Type de Forfait supprimé avec succès.');
        } catch (\Exception $e) {
            // Retournez une réponse en cas d'erreur
            return redirect()->back()->with('error', 'Erreur lors de la suppression du type de Forfait.');
        }
    }

    public function showForfaitForm()
    {
        $forfaits = Forfait::all(); // Récupérer tous les status depuis la base de données
        $types = TypeForfait::all();
        return view('params.form.forfait', compact('forfaits', 'types'));
    }

    public function addForfait(Request $request)
    {
        try {
            // Validez les données du formulaire
            $validatedData = $request->validate([
                //'id_client' => 'required|string',
                'created_at' => 'required|date',
                'valid_to' => 'required|date|after:created_at',
                'credit' => 'required|integer',
                'type_id' => 'required|exists:type_forfait,id_type',
            ]);

            // Créez un nouvel objet Forfait avec les données validées
            $forfait = new Forfait();
            //$forfait->id_client = $validatedData['id_client'];
            $forfait->created_at = $validatedData['created_at'];
            $forfait->valid_to = $validatedData['valid_to'];
            $forfait->credit = $validatedData['credit'];
            $forfait->id_type = $validatedData['type_id'];

            // Enregistrez les données dans la base de données
            $forfait->save();

            // Retournez une réponse de succès
            return redirect()->back()->with('success', 'Nouveau forfait ajouté avec succès!');
        } catch (\Exception $e) {
            // Retournez une réponse en cas d'erreur
            return redirect()->back()->with('error', 'Erreur lors de l\'ajout du forfait.');
        }
    }

    public function modifierForfait($id)
    {
        $forfait = Forfait::findOrFail($id); // Récupérer le statut correspondant à l'ID fourni
        $types = TypeForfait::all();
        $impacts = Impact::all();
        return view('params.form.ForfaitEdit', compact('forfait', 'types'));
    }

    public function updateForfait(Request $request, $id)
    {
        try{
            $request->validate([
                'id_client' => 'required',
                'created_at' => 'required|date',
                'valid_to' => 'required|date|after:created_at',
                'credit' => 'required|integer',
                'id_type' => 'required',
            ]);

            $forfait = Forfait::findOrFail($id);
            //$forfait->id_client = $request->input('id_client');
            $forfait->created_at = $request->input('created_at');
            $forfait->valid_to = $request->input('valid_to');
            $forfait->credit = $request->input('credit');
            $forfait->id_type = $request->input('id_type');
            $forfait->save();

            // Rediriger avec un message de succès
            return redirect()->route('params.form.forfait')->with('success', 'Forfait mise à jour avec succès.');
        } catch (\Exception $e) {
            // Retournez une réponse en cas d'erreur
            return redirect()->back()->with('error', 'Erreur lors de la modification du Forfait.');
        }
    }

    public function supprimerForfait($id)
    {
        try{
            $forfait = Forfait::findOrFail($id); // Récupérer le statut correspondant à l'ID fourni

            // Supprimer le statut
            $forfait->delete();

            // Rediriger avec un message de succès
            return redirect()->back()->with('success', 'Forfait supprimé avec succès.');
        } catch (\Exception $e) {
            // Retournez une réponse en cas d'erreur
            return redirect()->back()->with('error', 'Erreur lors de la suppression du Forfait.');
        }
    }

    public function showTechnicienForm()
    {
        $techniciens = Technicien::all();
        $roles = Role::all();
        $services = Service::all();

        return view('params.form.technicien', compact('techniciens', 'roles', 'services'));
    }


    public function addTechnicien(Request $request)
    {
        try {
            // Validez les données du formulaire
            //dd($request);
            $request->validate([
                'nom' => 'required|string|max:50',
                'prenom' => 'required|string|max:50',
                'email' => 'required|email|unique:techniciens,email',
                'id_role' => 'required|exists:role,id_role',
                'id_service' => 'required|exists:services,id_service',
            ]);
            // Créez un nouvel objet Forfait avec les données validées
            $technicien = new Technicien();
            $technicien->nom = $request->nom;
            $technicien->prenom = $request->prenom;
            $technicien->email = $request->email;
            $technicien->id_role = $request->id_role;
            $technicien->id_service = $request->id_service;
            $technicien->password = Hash::make('Toulouse@31');
            $technicien->created_at = Carbon::now();
            $technicien->save();

            // Retournez une réponse de succès
            return redirect()->back()->with('success', 'Nouveau technicien ajouté avec succès!');
        } catch (\Exception $e) {
            // Retournez une réponse en cas d'erreur
            return redirect()->back()->with('error', 'Erreur lors de l\'ajout du technicien.');
        }
    }

    public function modifierTechnicien($id)
    {
        $technicien = Technicien::findOrFail($id); // Récupérer le statut correspondant à l'ID
        $roles = Role::all();
        $services = Service::all();
        return view('params.form.technicienEdit', compact('technicien', 'roles', 'services'));
    }

    public function updateTechnicien(Request $request, $id)
    {
        try{
            $request->validate([
                'nom' => 'required|string|max:50',
                'prenom' => 'required|string|max:50',
                //'email' => 'required|email|unique:techniciens,email',
                'id_role' => 'required|exists:role,id_role',
                'id_service' => 'required|exists:services,id_service',
            ]);

            $technicien = Technicien::findOrFail($id);
            $technicien->nom = $request->nom;
            $technicien->prenom = $request->prenom;
            //$technicien->email = $request->email;
            $technicien->id_role = $request->id_role;
            $technicien->id_service = $request->id_service;
            if(!empty($request->password)){
                $technicien->password = Hash::make($request->password);
            }
            $technicien->save();

            // Rediriger avec un message de succès
            return redirect()->route('params.form.technicien')->with('success', 'Technicien mise à jour avec succès.');
        } catch (\Exception $e) {
            // Retournez une réponse en cas d'erreur
            return redirect()->back()->with('error', 'Erreur lors de la modification du technicien.');
        }
    }

    public function supprimerTechnicien($id)
    {
        try{
            $technicien = Technicien::findOrFail($id); // Récupérer le statut correspondant à l'ID fourni

            // Supprimer le statut
            $technicien->delete();

            // Rediriger avec un message de succès
            return redirect()->back()->with('success', 'Technicien supprimé avec succès.');
        } catch (\Exception $e) {
            // Retournez une réponse en cas d'erreur
            return redirect()->back()->with('error', 'Erreur lors de la suppression du Technicien.');
        }
    }

    public function sendEmail(){
        $messageContent = "Contenu de votre notification ici";

        Mail ::to('agustin.quintero@isociel.fr')->send(new NotificationEmail($messageContent));
    }
}
