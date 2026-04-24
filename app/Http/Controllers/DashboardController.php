<?php

namespace App\Http\Controllers;

use App\Models\Emprunt;
use App\Models\Livre;
use App\Models\Penalite;
use App\Models\User;
use App\Services\PenaltyService;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display the dashboard
     */
    public function index(PenaltyService $penaltyService)
    {
        /** @var User|null $user */
        $user = auth()->user();

        // Mettre à jour les pénalités des emprunts en retard avant d'afficher les compteurs
        $penaltyService->syncOverduePenalties();

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

            return view('dashboard.index', compact(
                'user',
                'borrowedBooks',
                'availableBooks',
                'overdueReturns',
                'pendingPenalties',
                'currentLoans'
            ));
        } else {
            // Vue utilisateur simple : seulement ses emprunts
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

    /**
     * Display the administration page.
     */
    public function administration(PenaltyService $penaltyService)
    {
        /** @var User|null $user */
        $user = auth()->user();

        if (!$user || $user->role_id < 2) {
            abort(403);
        }

        $penaltyService->syncOverduePenalties();

        $livres = Livre::with('empruntsCourants')->paginate(12);

        $empruntsEnCours = Emprunt::with(['user', 'livre'])
            ->where('statut', 'en_cours')
            ->orderBy('date_retour_prevue')
            ->get();

        $empruntsEnRetard = Emprunt::with(['user', 'livre'])
            ->where('statut', 'en_cours')
            ->where('date_retour_prevue', '<', now())
            ->orderBy('date_retour_prevue')
            ->get();

        $historiqueEmprunts = Emprunt::with(['user', 'livre', 'penalite'])
            ->where('statut', '!=', 'en_cours')
            ->orderBy('date_retour_reelle', 'desc')
            ->limit(50)
            ->get();

        $penalites = Penalite::with(['emprunt.user', 'emprunt.livre'])
            ->orderBy('payee')
            ->orderBy('date_application', 'desc')
            ->get();

        return view('administration.index', compact(
            'livres',
            'empruntsEnCours',
            'empruntsEnRetard',
            'historiqueEmprunts',
            'penalites'
        ));
    }
}
