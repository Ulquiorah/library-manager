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
}
