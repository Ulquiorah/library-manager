<?php

namespace App\Http\Controllers;

use App\Models\Emprunt;
use App\Models\Livre;
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

        $borrowedBooks = Emprunt::where('statut', 'en_cours')->count();
        $availableBooks = Livre::where('quantite_disponible', '>', 0)->count();
        $overdueReturns = Emprunt::where('statut', 'en_cours')
            ->where('date_retour_prevue', '<', now())
            ->count();
        $pendingPenalties = $user->penalites()->where('payee', false)->sum('montant');
        $currentLoans = $user->emprunts()->where('statut', 'en_cours')->with('livre')->get();

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
