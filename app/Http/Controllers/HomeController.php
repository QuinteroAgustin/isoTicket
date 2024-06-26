<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Ticket;
use App\Models\Technicien;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function home()
    {
        // Récupère tous les tickets
        $tickets = Ticket::All();

        // Récupère la date du jour
        $dateJour = Carbon::today();
        // Récupère les tickets créés aujourd'hui
        $ticketsJour = Ticket::whereDate('created_at', $dateJour)->get();
        // Récupère les tickets créés aujourd'hui
        $ticketsClotsJour = Ticket::whereDate('closed_at', $dateJour)->get();
        // Récupère les tickets clots aujourd'hui
        $ticketsClots = Ticket::where('cloture', 1)->get();

        // Récupère la date d'hier
        $hier = Carbon::yesterday();
        // Récupère les tickets créés hier
        $ticketsHier = Ticket::whereDate('created_at', $hier)->get();

        // Récupère le début et la fin du mois en cours
        $debutMois = Carbon::now()->startOfMonth();
        $finMois = Carbon::now()->endOfMonth();

        // Récupère les tickets créés pendant le mois en cours
        $ticketsMoisEnCours = Ticket::whereBetween('created_at', [$debutMois, $finMois])->get();

        // Calcul de la différence en pourcentage entre aujourd'hui et hier
        $countJour = $ticketsJour->count();
        $countHier = $ticketsHier->count();
        if ($countHier > 0) {
            $pourcentageDifference = (($countJour - $countHier) / $countJour) * 100;
        } else {
            $pourcentageDifference = $countJour > 0 ? 100 : 0; // Si aucun ticket hier, le pourcentage est de 100% si des tickets aujourd'hui, sinon 0%
        }

            return view('home.index', compact('tickets', 'ticketsJour', 'ticketsHier', 'ticketsMoisEnCours', 'pourcentageDifference', 'ticketsClots', 'ticketsClotsJour'));
        }

    public function notFound()
    {
        return view('error.404');
    }

    public function login()
    {
        return view('home.login');
    }

    public function loginPost(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Technicien::login($credentials['email'], $credentials['password'])) {
            // Rediriger l'utilisateur vers une autre vue après la connexion réussie
            return redirect()->route('home');
        } else {
            // Si les informations d'identification sont incorrectes, rediriger l'utilisateur vers la page de connexion avec un message d'erreur
            return redirect()->route('login')->with('error', 'Adresse e-mail ou mot de passe incorrect.');
        }
    }

    public function logoutPost(Request $request)
    {
        Technicien::logout();
        return redirect('/login');
    }
}
