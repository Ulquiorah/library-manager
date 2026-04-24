<?php

namespace App\Services;

use App\Models\Emprunt;
use App\Models\Penalite;
use Carbon\Carbon;

class PenaltyService
{
    /**
     * Synchronise les pénalités de tous les emprunts en retard.
     */
    public function syncOverduePenalties(): void
    {
        $overdueLoans = Emprunt::with(['livre', 'penalite'])
            ->where('statut', config('library.borrow_statuses.en_cours'))
            ->where('date_retour_prevue', '<', now())
            ->get();

        foreach ($overdueLoans as $loan) {
            $this->syncPenaltyForLoan($loan);
        }
    }

    /**
     * Crée ou met à jour la pénalité d'un emprunt en retard.
     */
    public function syncPenaltyForLoan(Emprunt $loan, ?Carbon $referenceDate = null): ?Penalite
    {
        $referenceDate ??= now();
        $lateDays = $loan->jours_retard($referenceDate);

        if ($lateDays <= 0) {
            return null;
        }

        $amount = $loan->montant_penalite($referenceDate);
        $reason = "Retard de {$lateDays} jour(s).";

        $existingPenalty = $loan->penalite;
        $isPaid = $existingPenalty?->payee ?? false;

        return Penalite::updateOrCreate(
            ['emprunt_id' => $loan->id],
            [
                'user_id' => $loan->user_id,
                'montant' => $amount,
                'raison' => $reason,
                'date_application' => $referenceDate,
                'payee' => $isPaid,
                'date_paiement' => $isPaid ? $existingPenalty?->date_paiement : null,
            ]
        );
    }
}
