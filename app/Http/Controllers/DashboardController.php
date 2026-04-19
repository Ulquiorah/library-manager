<?php

namespace App\Http\Controllers;

use App\Models\Emprunt;
use App\Models\Livre;
use App\Models\Penalite;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display the dashboard
     */
    public function index()
    {
        /** @var User|null $user */
        $user = auth()->user();

        if ($user->role_id >= 2) {
            // Vue administrateur/bibliothécaire : tous les emprunts en cours
            $currentLoans = Emprunt::with(['user', 'livre'])
                ->where('statut', 'en_cours')
                ->orderBy('date_retour_prevue')
                ->get();

            $borrowedBooks = Emprunt::where('statut', 'en_cours')->count();
            $availableBooks = Livre::where('quantite_disponible', '>', 0)->count();
            $overdueReturns = Emprunt::where('statut', 'en_cours')
                ->where('date_retour_prevue', '<', now())
                ->count();
            $pendingPenalties = Penalite::where('payee', false)->sum('montant');
        } else {
            // Vue utilisateur simple : seulement ses emprunts
            $borrowedBooks = Emprunt::where('statut', 'en_cours')->count();
            $availableBooks = Livre::where('quantite_disponible', '>', 0)->count();
            $overdueReturns = Emprunt::where('statut', 'en_cours')
                ->where('date_retour_prevue', '<', now())
                ->count();
            $pendingPenalties = $user->penalites()->where('payee', false)->sum('montant');
            $currentLoans = $user->emprunts()->where('statut', 'en_cours')->with('livre')->get();
        }

        return view('dashboard.index', compact(
            'user',
            'borrowedBooks',
            'availableBooks',
            'overdueReturns',
            'pendingPenalties',
            'currentLoans'
        ));
    }
}
