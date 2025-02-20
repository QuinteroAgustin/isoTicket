<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Ticket;
use App\Models\Technicien;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller
{
    public function home()
    {
        //$user = Technicien::findOrFail(Technicien::getTechId());
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

        $monthFormatted = Carbon::now()->timezone('Europe/Paris')->translatedFormat('F Y');

        // Calcul de la différence en pourcentage entre aujourd'hui et hier
        $countJour = $ticketsJour->count();
        $countHier = $ticketsHier->count();
        if ($countHier > 0 && $countJour > 0) {
            $pourcentageDifference = (($countJour - $countHier) / $countJour) * 100;
        } else {
            $pourcentageDifference = $countJour > 0 ? 100 : 0; // Si aucun ticket hier, le pourcentage est de 100% si des tickets aujourd'hui, sinon 0%
        }

        $techniciens = Technicien::all();
        // Statistiques des techniciens pour le mois en cours
        $technicienStats = Ticket::where('cloture', 1)
        ->whereMonth('closed_at', now()->month)
        ->whereYear('closed_at', now()->year)
        ->whereNotNull('id_technicien')
        ->select('id_technicien', DB::raw('count(*) as total'))
        ->groupBy('id_technicien')
        ->orderByDesc('total')
        ->with('technicien')
        ->get();

        // Formater la date du jour
        $dateFormatted = Carbon::now()->timezone('Europe/Paris')->translatedFormat('l d F Y H:i:s');

        return view('home.index', compact(
        'tickets', 
        'ticketsJour', 
        'ticketsHier', 
        'ticketsMoisEnCours', 
        'pourcentageDifference', 
        'ticketsClots', 
        'ticketsClotsJour', 
        'techniciens', 
        'dateFormatted',
        'technicienStats',
        'monthFormatted'
        ));
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
        $validator = Validator::make($credentials, [
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ], [
            'required' => 'Des champs sont obligatoires.',
            'password.min' => 'Le mot de passe doit contenir au moins 8 caractères.',
            'email.email' => 'Veuillez fournir une adresse email valide.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput($request->only('email'));
        }


        if (Technicien::login($credentials['email'], $credentials['password'])) {
            // Gérer les cookies "remember_me"
            $remember = $request->has('remember_me');
            $cookieTime = 60 * 24 * 30; // 30 jours

            if ($remember) {
                Cookie::queue('email', $credentials['email'], $cookieTime);
                Cookie::queue('remember_me', 'true', $cookieTime);
            } else {
                Cookie::queue(Cookie::forget('email'));
                Cookie::queue(Cookie::forget('remember_me'));
            }
            // Rediriger l'utilisateur vers une autre vue après la connexion réussie
            return redirect()->route('home');
        } else {
             // Si la tentative échoue, renvoyer à la page de connexion avec un message d'erreur
            return redirect()->back()
                ->withErrors(['email' => 'Informations d\'identification incorrectes.'])
                ->withInput($request->only('email'));
        }
    }

    public function logoutPost()
    {
        Technicien::logout();
        Cookie::queue(Cookie::forget('email'));
        Cookie::queue(Cookie::forget('remember_me'));
        return redirect('/login');
    }


    public function refreshTicketsData()
    {
        // Récupération des tickets et autres données
        $tickets = Ticket::all();
        $dateJour = Carbon::today();
        $ticketsJour = Ticket::whereDate('created_at', $dateJour)->get();
        $ticketsClotsJour = Ticket::whereDate('closed_at', $dateJour)->get();
        $ticketsClots = Ticket::where('cloture', 1)->get();

        $hier = Carbon::yesterday();
        $ticketsHier = Ticket::whereDate('created_at', $hier)->get();

        $debutMois = Carbon::now()->startOfMonth();
        $finMois = Carbon::now()->endOfMonth();

        $ticketsMoisEnCours = Ticket::whereBetween('created_at', [$debutMois, $finMois])->get();

        $countJour = $ticketsJour->count();
        $countHier = $ticketsHier->count();

        if ($countHier > 0 && $countJour > 0) {
            $pourcentageDifference = (($countJour - $countHier) / $countJour) * 100;
        } else {
            $pourcentageDifference = $countJour > 0 ? 100 : 0;
        }

        // Récupération de la date formatée
        $dateFormatted = Carbon::now()->timezone('Europe/Paris')->translatedFormat('l d F Y H:i:s');
        $monthFormatted = Carbon::now()->timezone('Europe/Paris')->translatedFormat('F Y');

        // Ajout des stats techniciens
        $technicienStats = Ticket::where('cloture', 1)
            ->whereMonth('closed_at', now()->month)
            ->whereYear('closed_at', now()->year)
            ->whereNotNull('id_technicien')
            ->select('id_technicien', DB::raw('count(*) as total'))
            ->groupBy('id_technicien')
            ->orderByDesc('total')
            ->with('technicien')
            ->get();

        // Génération de l'HTML pour les statistiques
        $html = view('home.render.ticket_stats', compact(
            'tickets', 'ticketsJour', 'ticketsClotsJour', 'ticketsClots',
            'pourcentageDifference', 'dateFormatted', 'monthFormatted', 'technicienStats'
        ))->render();

        return response()->json(['html' => $html]);
    }
}
