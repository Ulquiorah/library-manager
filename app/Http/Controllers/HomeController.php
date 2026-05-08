<?php

namespace App\Http\Controllers;

use App\Models\Emprunt;
use App\Models\Livre;
use App\Models\Penalite;
use App\Services\PenaltyService;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display the home page for users with role_id = 1
     */
    public function index(PenaltyService $penaltyService)
    {
        /** @var User|null $user */
        $user = auth()->user();

        // Vérifier que l'utilisateur a le rôle user (role_id = 1)
        if (!$user || $user->role_id !== 1) {
            abort(403, 'Accès non autorisé');
        }

        // Mettre à jour les pénalités des emprunts en retard
        $penaltyService->syncOverduePenalties();

        // Statistiques pour l'utilisateur
        $myCurrentLoans = $user->emprunts()->where('statut', 'en_cours')->with('livre')->get();
        $borrowedBooksCount = $myCurrentLoans->count();
        $availableBooks = Livre::where('quantite_disponible', '>', 0)->count();
        $myOverdueReturns = $user->emprunts()
            ->where('statut', 'en_cours')
            ->where('date_retour_prevue', '<', now())
            ->count();
        $myPendingPenalties = $user->penalites()->where('payee', false)->sum('montant');

        // Livres récents disponibles
        $recentBooks = Livre::where('quantite_disponible', '>', 0)
            ->orderBy('created_at', 'desc')
            ->limit(6)
            ->get();

        return view('home.index', compact(
            'user',
            'myCurrentLoans',
            'borrowedBooksCount',
            'availableBooks',
            'myOverdueReturns',
            'myPendingPenalties',
            'recentBooks'
        ));
    }
}
