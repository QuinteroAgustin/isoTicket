<?php

use App\Http\Middleware\CheckRole;
use App\Http\Middleware\Authenticate;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ParamsController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\RechercheController;
use App\Http\Middleware\RememberMeMiddleware;
use App\Http\Middleware\RedirectIfAuthenticated;
use App\Http\Controllers\PasswordResetController;



//Middleware
//'checkrole:1'
//Authenticate::class

//accueil
Route::get('/', [HomeController::class, 'home'])->name('home')->middleware(Authenticate::class);

//users
Route::middleware([RememberMeMiddleware::class])->group(function () {
Route::get('/login', [HomeController::class, 'login'])->name('login')->middleware(RedirectIfAuthenticated::class);
Route::post('/login', [HomeController::class, 'loginPost'])->name('loginPost')->middleware(RedirectIfAuthenticated::class);
});
Route::get('/logout', [HomeController::class, 'logoutPost'])->name('logout')->middleware(Authenticate::class);

// Route pour afficher le formulaire de saisie de l'adresse e-mail
Route::get('/password/reset', [PasswordResetController::class, 'showEmailForm'])->name('password.request');

// Route pour envoyer le lien de réinitialisation de mot de passe
Route::post('/password/reset-link', [PasswordResetController::class, 'sendResetLink'])->name('password.email');

// Route pour afficher le formulaire de réinitialisation du mot de passe avec le token
Route::get('/password/reset/{token}', [PasswordResetController::class, 'showResetForm'])->name('password.reset');

// Route pour traiter la réinitialisation du mot de passe
Route::post('/password/reset', [PasswordResetController::class, 'resetPassword'])->name('password.update');

//erreur
Route::get('/404', [HomeController::class, 'notFound'])->name('404');

// users profil
Route::get('/profile', [UserController::class, 'edit'])->name('profile.edit');
Route::post('/profile', [UserController::class, 'update'])->name('profile.update');

//tickets
Route::get('/ticket', [TicketController::class, 'ticket'])->name('ticket')->middleware(Authenticate::class);

Route::get('/ticket/{id}/edit', [TicketController::class, 'edit'])->name('ticket.edit')->middleware(Authenticate::class);

Route::post('/ticket/{id}/newmessage', [TicketController::class, 'newMessage'])->name('ticket.newMessage')->middleware(Authenticate::class);
Route::post('/ticket/{id}/edit', [TicketController::class, 'editPost'])->name('ticket.edit.post')->middleware(Authenticate::class);
Route::get('/ticket/forfait/{id}/credit', [TicketController::class, 'getRemainingCredit'])->middleware(Authenticate::class);
Route::get('/ticket/{id}/call', [TicketController::class, 'callClient'])->name('call.client')->middleware(Authenticate::class);

Route::get('/ticket/{id}/edit/{id_contact}/contact', [TicketController::class, 'editContact'])->name('ticket.edit.contact')->middleware(Authenticate::class);
Route::post('/ticket/{id}/edit/{id_contact}/contact', [TicketController::class, 'editContactPost'])->name('ticket.edit.contact.post')->middleware(Authenticate::class);
Route::get('/ticket/{id}/edit/contact', [TicketController::class, 'createContact'])->name('ticket.create.contact')->middleware(Authenticate::class);
Route::get('/ticket/edit/contact', [TicketController::class, 'createContactNoId'])->name('ticket.create.contact.noid')->middleware(Authenticate::class);
Route::post('/ticket/{id}/edit/contact', [TicketController::class, 'createContactPost'])->name('ticket.create.contact.post')->middleware(Authenticate::class);
Route::post('/ticket/edit/contact', [TicketController::class, 'createContactPostNoId'])->name('ticket.create.contactnoid.post')->middleware(Authenticate::class);


Route::get('/ticket/cloture', [TicketController::class, 'ticket_clots'])->name('ticket.clots')->middleware(Authenticate::class);
Route::get('/create', [TicketController::class, 'createVue'])->name('create')->middleware(Authenticate::class);
Route::post('/create', [TicketController::class, 'create'])->name('createPost')->middleware(Authenticate::class);

Route::get('/ticket/{id}/decloture', [TicketController::class, 'decloture'])->name('ticket.decloture');

//recherche de client (axios)
Route::get('/create/search-clients', [TicketController::class, 'searchClients'])->name('search.clients')->middleware(Authenticate::class);


Route::get('/create/client/{client_id}', [TicketController::class, 'getContacts'])->name('client.contacts')->middleware(Authenticate::class);
Route::get('/create/client/{client_id}/contacttableau', [TicketController::class, 'getContactsTab'])->name('client.contacts.tab')->middleware(Authenticate::class);
Route::get('/create/client/{client_id}/societetableau', [TicketController::class, 'getClientTab'])->name('client.client.tab')->middleware(Authenticate::class);

Route::get('/ticket/search-abonnementtableau/{clientId}', [TicketController::class, 'getAbonnementsByClient'])->name('client.abonnement.tab')->middleware(Authenticate::class);

//params
Route::get('/params', [ParamsController::class, 'home'])->name('params')->middleware([Authenticate::class, 'CheckRole:4']);

// Route pour afficher le formulaire d'ajout de statut
Route::get('/params/status', [ParamsController::class, 'showStatusForm'])->name('params.form.status')->middleware([Authenticate::class, 'CheckRole:2']);
Route::post('/params/status/ajouter', [ParamsController::class, 'addStatus'])->name('params.status.add')->middleware([Authenticate::class, 'CheckRole:2']);
Route::get('/params/status/modifier/{id}', [ParamsController::class, 'modifierStatus'])->name('params.status.modifier')->middleware([Authenticate::class, 'CheckRole:2']);
Route::post('/params/status/modifier/{id}', [ParamsController::class, 'updateStatus'])->name('params.status.update')->middleware([Authenticate::class, 'CheckRole:2']);
Route::delete('/params/status/supprimer/{id}', [ParamsController::class, 'supprimerStatus'])->name('params.status.supprimer')->middleware([Authenticate::class, 'CheckRole:2']);

// Route pour afficher le formulaire d'ajout de priorite
Route::get('/params/priorite', [ParamsController::class, 'showPrioriteForm'])->name('params.form.priorite')->middleware([Authenticate::class, 'CheckRole:2']);
Route::post('/params/priorite/ajouter', [ParamsController::class, 'addPriorite'])->name('params.priorite.add')->middleware([Authenticate::class, 'CheckRole:2']);
Route::get('/params/priorite/modifier/{id}', [ParamsController::class, 'modifierPriorite'])->name('params.priorite.modifier')->middleware([Authenticate::class, 'CheckRole:2']);
Route::post('/params/priorite/modifier/{id}', [ParamsController::class, 'updatePriorite'])->name('params.priorite.update')->middleware([Authenticate::class, 'CheckRole:2']);
Route::delete('/params/priorite/supprimer/{id}', [ParamsController::class, 'supprimerPriorite'])->name('params.priorite.supprimer')->middleware([Authenticate::class, 'CheckRole:2']);

// Route pour afficher le formulaire d'ajout d'impact
Route::get('/params/impact', [ParamsController::class, 'showImpactForm'])->name('params.form.impact')->middleware([Authenticate::class, 'CheckRole:2']);
Route::post('/params/impact/ajouter', [ParamsController::class, 'addImpact'])->name('params.impact.add')->middleware([Authenticate::class, 'CheckRole:2']);
Route::get('/params/impact/modifier/{id}', [ParamsController::class, 'modifierImpact'])->name('params.impact.modifier')->middleware([Authenticate::class, 'CheckRole:2']);
Route::post('/params/impact/modifier/{id}', [ParamsController::class, 'updateImpact'])->name('params.impact.update')->middleware([Authenticate::class, 'CheckRole:2']);
Route::delete('/params/impact/supprimer/{id}', [ParamsController::class, 'supprimerImpact'])->name('params.impact.supprimer')->middleware([Authenticate::class, 'CheckRole:2']);

// Route pour afficher le formulaire d'ajout de fonction
Route::get('/params/fonction', [ParamsController::class, 'showFonctionForm'])->name('params.form.fonction')->middleware([Authenticate::class, 'CheckRole:2']);
Route::post('/params/fonction/ajouter', [ParamsController::class, 'addFonction'])->name('params.fonction.add')->middleware([Authenticate::class, 'CheckRole:2']);
Route::get('/params/fonction/modifier/{id}', [ParamsController::class, 'modifierFonction'])->name('params.fonction.modifier')->middleware([Authenticate::class, 'CheckRole:2']);
Route::post('/params/fonction/modifier/{id}', [ParamsController::class, 'updateFonction'])->name('params.fonction.update')->middleware([Authenticate::class, 'CheckRole:2']);
Route::delete('/params/fonction/supprimer/{id}', [ParamsController::class, 'supprimerFonction'])->name('params.fonction.supprimer')->middleware([Authenticate::class, 'CheckRole:2']);

// Route pour afficher le formulaire d'ajout de service
Route::get('/params/service', [ParamsController::class, 'showServiceForm'])->name('params.form.service')->middleware([Authenticate::class, 'CheckRole:2']);
Route::post('/params/service/ajouter', [ParamsController::class, 'addService'])->name('params.service.add')->middleware([Authenticate::class, 'CheckRole:2']);
Route::get('/params/service/modifier/{id}', [ParamsController::class, 'modifierService'])->name('params.service.modifier')->middleware([Authenticate::class, 'CheckRole:2']);
Route::post('/params/service/modifier/{id}', [ParamsController::class, 'updateService'])->name('params.service.update')->middleware([Authenticate::class, 'CheckRole:2']);
Route::delete('/params/service/supprimer/{id}', [ParamsController::class, 'supprimerService'])->name('params.service.supprimer')->middleware([Authenticate::class, 'CheckRole:2']);

// Route pour afficher le formulaire d'ajout de categorie
Route::get('/params/categorie', [ParamsController::class, 'showCategorieForm'])->name('params.form.categorie')->middleware([Authenticate::class, 'CheckRole:2']);
Route::post('/params/categorie/ajouter', [ParamsController::class, 'addCategorie'])->name('params.categorie.add')->middleware([Authenticate::class, 'CheckRole:2']);
Route::get('/params/categorie/modifier/{id}', [ParamsController::class, 'modifierCategorie'])->name('params.categorie.modifier')->middleware([Authenticate::class, 'CheckRole:2']);
Route::post('/params/categorie/modifier/{id}', [ParamsController::class, 'updateCategorie'])->name('params.categorie.update')->middleware([Authenticate::class, 'CheckRole:2']);
Route::delete('/params/categorie/supprimer/{id}', [ParamsController::class, 'supprimerCategorie'])->name('params.categorie.supprimer')->middleware([Authenticate::class, 'CheckRole:2']);

// Route pour afficher le formulaire d'ajout de risque
Route::get('/params/risque', [ParamsController::class, 'showRisqueForm'])->name('params.form.risque')->middleware([Authenticate::class, 'CheckRole:2']);
Route::post('/params/risque/ajouter', [ParamsController::class, 'addRisque'])->name('params.risque.add')->middleware([Authenticate::class, 'CheckRole:2']);
Route::get('/params/risque/modifier/{id}', [ParamsController::class, 'modifierRisque'])->name('params.risque.modifier')->middleware([Authenticate::class, 'CheckRole:2']);
Route::post('/params/risque/modifier/{id}', [ParamsController::class, 'updateRisque'])->name('params.risque.update')->middleware([Authenticate::class, 'CheckRole:2']);
Route::delete('/params/risque/supprimer/{id}', [ParamsController::class, 'supprimerRisque'])->name('params.risque.supprimer')->middleware([Authenticate::class, 'CheckRole:2']);

// Route pour afficher le formulaire d'ajout de role
Route::get('/params/role', [ParamsController::class, 'showRoleForm'])->name('params.form.role')->middleware([Authenticate::class, 'CheckRole:1']);
Route::post('/params/role/ajouter', [ParamsController::class, 'addRole'])->name('params.role.add')->middleware([Authenticate::class, 'CheckRole:1']);
Route::get('/params/role/modifier/{id}', [ParamsController::class, 'modifierRole'])->name('params.role.modifier')->middleware([Authenticate::class, 'CheckRole:1']);
Route::post('/params/role/modifier/{id}', [ParamsController::class, 'updateRole'])->name('params.role.update')->middleware([Authenticate::class, 'CheckRole:1']);
Route::delete('/params/role/supprimer/{id}', [ParamsController::class, 'supprimerRole'])->name('params.role.supprimer')->middleware([Authenticate::class, 'CheckRole:1']);

// Route pour afficher le formulaire d'ajout de typeForfait
Route::get('/params/typeForfait', [ParamsController::class, 'showTypeForfaitForm'])->name('params.form.typeForfait')->middleware([Authenticate::class, 'CheckRole:4']);
Route::post('/params/typeForfait/ajouter', [ParamsController::class, 'addTypeForfait'])->name('params.typeForfait.add')->middleware([Authenticate::class, 'CheckRole:4']);
Route::get('/params/typeForfait/modifier/{id}', [ParamsController::class, 'modifierTypeForfait'])->name('params.typeForfait.modifier')->middleware([Authenticate::class, 'CheckRole:4']);
Route::post('/params/typeForfait/modifier/{id}', [ParamsController::class, 'updateTypeForfait'])->name('params.typeForfait.update')->middleware([Authenticate::class, 'CheckRole:4']);
Route::delete('/params/typeForfait/supprimer/{id}', [ParamsController::class, 'supprimerTypeForfait'])->name('params.typeForfait.supprimer')->middleware([Authenticate::class, 'CheckRole:4']);

// Route pour afficher le formulaire d'ajout de forfait
Route::get('/params/forfait', [ParamsController::class, 'showForfaitForm'])->name('params.form.forfait')->middleware([Authenticate::class, 'CheckRole:4']);
Route::post('/params/forfait/ajouter', [ParamsController::class, 'addForfait'])->name('params.forfait.add')->middleware([Authenticate::class, 'CheckRole:4']);
Route::get('/params/forfait/modifier/{id}', [ParamsController::class, 'modifierForfait'])->name('params.forfait.modifier')->middleware([Authenticate::class, 'CheckRole:4']);
Route::post('/params/forfait/modifier/{id}', [ParamsController::class, 'updateForfait'])->name('params.forfait.update')->middleware([Authenticate::class, 'CheckRole:4']);
Route::delete('/params/forfait/supprimer/{id}', [ParamsController::class, 'supprimerForfait'])->name('params.forfait.supprimer')->middleware([Authenticate::class, 'CheckRole:4']);

// Route pour afficher le formulaire d'ajout de technicien
Route::get('/params/technicien', [ParamsController::class, 'showTechnicienForm'])->name('params.form.technicien')->middleware([Authenticate::class, 'CheckRole:1']);
Route::post('/params/technicien/ajouter', [ParamsController::class, 'addTechnicien'])->name('params.technicien.add')->middleware([Authenticate::class, 'CheckRole:1']);
Route::get('/params/technicien/modifier/{id}', [ParamsController::class, 'modifierTechnicien'])->name('params.technicien.modifier')->middleware([Authenticate::class, 'CheckRole:1']);
Route::post('/params/technicien/modifier/{id}', [ParamsController::class, 'updateTechnicien'])->name('params.technicien.update')->middleware([Authenticate::class, 'CheckRole:1']);
Route::delete('/params/technicien/supprimer/{id}', [ParamsController::class, 'supprimerTechnicien'])->name('params.technicien.supprimer')->middleware([Authenticate::class, 'CheckRole:1']);


//recherches
Route::get('/recherche', [RechercheController::class, 'home'])->name('recherche')->middleware(Authenticate::class);
Route::get('/recherche/filtre', [RechercheController::class, 'filtre'])->name('recherche.filtre')->middleware(Authenticate::class);

//refresh
Route::get('/refresh-tickets-data', [HomeController::class, 'refreshTicketsData'])->name('refreshTicketsData');

// Clients
Route::get('/clients', [ClientController::class, 'index'])->name('clients.index')->middleware(Authenticate::class);
Route::get('/clients/info/{id}', [ClientController::class, 'info'])->name('clients.info')->middleware(Authenticate::class);
//contact creation edit
Route::get('/contact/edit/{id_contact}', [ClientController::class, 'editContact'])->name('edit.contact')->middleware(Authenticate::class);
Route::post('/contact/edit/{id_contact}', [ClientController::class, 'editContactPost'])->name('edit.contact.post')->middleware(Authenticate::class);
Route::get('/contact/create/{id_client}', [ClientController::class, 'createContact'])->name('create.contact')->middleware(Authenticate::class);
Route::post('/contact/create/{id_client}', [ClientController::class, 'createContactPost'])->name('create.contact.post')->middleware(Authenticate::class);

//Edition d'un message d'un ticket
Route::post('/ticket/message/{id}/update', [TicketController::class, 'updateMessage'])->name('ticket.message.update');

//liste des anciens tickets
Route::get('/ticket/client/{clientId}/previous', [TicketController::class, 'getPreviousTickets']);
Route::get('/ticket/client/{clientId}/forfaits', [TicketController::class, 'getForfaits']);
Route::get('/ticket/client/{clientId}/tickets-forfaits', [TicketController::class, 'getTicketsForfaits']);