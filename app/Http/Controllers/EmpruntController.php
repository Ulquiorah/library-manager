<?php

namespace App\Http\Controllers;

use App\Models\Emprunt;
use App\Models\Livre;
use App\Models\User;
use App\Services\PenaltyService;
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

    public function return(Request $request, Emprunt $emprunt, PenaltyService $penaltyService)
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

        // Créer / mettre à jour la pénalité si en retard
        $penalty = $penaltyService->syncPenaltyForLoan($emprunt->fresh(['penalite']), $dateRetour);

        $message = 'Le livre a été retourné avec succès.';
        if ($penalty) {
            $message .= ' Une pénalité de ' . number_format($penalty->montant, 2, ',', ' ') . '€ a été appliquée.';
        }

        return redirect()->back()->with('success', $message);
    }
}
