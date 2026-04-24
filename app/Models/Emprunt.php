<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Emprunt extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'livre_id',
        'date_emprunt',
        'date_retour_prevue',
        'date_retour_reelle',
        'statut',
    ];

    protected $casts = [
        'date_emprunt' => 'datetime',
        'date_retour_prevue' => 'datetime',
        'date_retour_reelle' => 'datetime',
    ];

    /**
     * Relations
     */

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function livre()
    {
        return $this->belongsTo(Livre::class);
    }

    public function penalite()
    {
        return $this->hasOne(Penalite::class);
    }

    /**
     * Accesseurs
     */

    public function jours_retard(?Carbon $referenceDate = null)
    {
        $referenceDate ??= now();

        if ($this->statut === 'retourne') {
            if (!$this->date_retour_reelle || !$this->date_retour_prevue) {
                return 0;
            }

            if ($this->date_retour_reelle->lessThanOrEqualTo($this->date_retour_prevue)) {
                return 0;
            }

            return $this->date_retour_prevue->diffInDays($this->date_retour_reelle);
        }

        if ($this->date_retour_prevue && $referenceDate->greaterThan($this->date_retour_prevue)) {
            return $this->date_retour_prevue->diffInDays($referenceDate);
        }

        return 0;
    }

    public function montant_penalite(?Carbon $referenceDate = null)
    {
        $jours = $this->jours_retard($referenceDate);
        $montant = $jours * config('library.penalty_per_day');
        return min($montant, config('library.max_penalty_amount'));
    }

    public function en_retard(?Carbon $referenceDate = null)
    {
        return $this->jours_retard($referenceDate) > 0;
    }
}

