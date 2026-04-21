<?php

namespace App\Http\Controllers;

use App\Models\Emprunt;
use App\Models\Livre;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmpruntController extends Controller
{
    public function store(Request $request, Livre $livre)
    {
        /** @var User $user */
        $user = Auth::user();

        if ($user->role_id >= 2) {
            return redirect()->back()->with('error', 'Les bibliothécaires ne peuvent pas emprunter de livres depuis cette interface.');
        }

        if (!$livre->estDisponible()) {
            return redirect()->back()->with('error', 'Ce livre n\'est pas disponible pour le moment.');
        }

        $currentLoans = $user->emprunts()->where('statut', config('library.borrow_statuses.en_cours'))->count();
        if ($currentLoans >= config('library.max_books_per_user')) {
            return redirect()->back()->with('error', 'Vous avez atteint le nombre maximum d\'emprunts autorisés.');
        }

        $existingLoan = $user->emprunts()
            ->where('livre_id', $livre->id)
            ->where('statut', config('library.borrow_statuses.en_cours'))
            ->exists();

        if ($existingLoan) {
            return redirect()->back()->with('error', 'Vous avez déjà emprunté ce livre.');
        }

        $duration = config('library.category_durations.' . $livre->categorie, config('library.borrow_duration'));
        $dateEmprunt = Carbon::now();
        $dateRetourPrevue = $dateEmprunt->copy()->addDays($duration);

        Emprunt::create([
            'user_id' => $user->id,
            'livre_id' => $livre->id,
            'date_emprunt' => $dateEmprunt,
            'date_retour_prevue' => $dateRetourPrevue,
            'statut' => config('library.borrow_statuses.en_cours'),
        ]);

        $livre->decrement('quantite_disponible');

        return redirect()->back()->with('success', 'Le livre a été emprunté avec succès.');
    }

    public function return(Request $request, Emprunt $emprunt)
    {
        $user = Auth::user();

        // Vérifier que l'utilisateur peut retourner ce livre
        if ($user->role_id < 2 && $emprunt->user_id !== $user->id) {
            return redirect()->back()->with('error', 'Vous ne pouvez pas retourner un livre que vous n\'avez pas emprunté.');
        }

        if ($emprunt->statut !== config('library.borrow_statuses.en_cours')) {
            return redirect()->back()->with('error', 'Cet emprunt n\'est pas en cours.');
        }

        $dateRetour = Carbon::now();
        $emprunt->update([
            'date_retour_reelle' => $dateRetour,
            'statut' => config('library.borrow_statuses.retourne'),
        ]);

        // Remettre le livre à disposition
        $emprunt->livre->increment('quantite_disponible');

        // Créer une pénalité si en retard
        if ($emprunt->en_retard()) {
            $montant = $emprunt->montant_penalite();
            if ($montant > 0) {
                $emprunt->penalite()->create([
                    'montant' => $montant,
                    'payee' => false,
                    'date_creation' => $dateRetour,
                ]);
            }
        }

        $message = 'Le livre a été retourné avec succès.';
        if ($emprunt->en_retard()) {
            $message .= ' Une pénalité de ' . $emprunt->montant_penalite() . '€ a été appliquée.';
        }

        return redirect()->back()->with('success', $message);
    }

    public function index()
    {
        $user = Auth::user();

        if ($user->role_id < 2) {
            return redirect()->route('dashboard')->with('error', 'Accès non autorisé.');
        }

        // Statistiques
        $stats = [
            'total_emprunts' => Emprunt::count(),
            'emprunts_en_cours' => Emprunt::where('statut', config('library.borrow_statuses.en_cours'))->count(),
            'emprunts_en_retard' => Emprunt::where('statut', config('library.borrow_statuses.en_cours'))
                ->where('date_retour_prevue', '<', now())->count(),
            'penalites_total' => \App\Models\Penalite::where('payee', false)->sum('montant'),
        ];

        // Emprunts en cours
        $empruntsEnCours = Emprunt::with(['user', 'livre'])
            ->where('statut', config('library.borrow_statuses.en_cours'))
            ->orderBy('date_retour_prevue')
            ->paginate(20, ['*'], 'en_cours_page');

        // Emprunts en retard
        $empruntsEnRetard = Emprunt::with(['user', 'livre'])
            ->where('statut', config('library.borrow_statuses.en_cours'))
            ->where('date_retour_prevue', '<', now())
            ->orderBy('date_retour_prevue')
            ->paginate(20, ['*'], 'retard_page');

        // Historique des emprunts
        $historiqueEmprunts = Emprunt::with(['user', 'livre', 'penalite'])
            ->where('statut', '!=', config('library.borrow_statuses.en_cours'))
            ->orderBy('date_retour_reelle', 'desc')
            ->paginate(20, ['*'], 'historique_page');

        // Pénalités
        $penalites = \App\Models\Penalite::with(['emprunt.user', 'emprunt.livre'])
            ->orderBy('payee')
            ->orderBy('date_creation', 'desc')
            ->paginate(20, ['*'], 'penalites_page');

        return view('emprunts.index', compact(
            'stats',
            'empruntsEnCours',
            'empruntsEnRetard',
            'historiqueEmprunts',
            'penalites'
        ));
    }
}
