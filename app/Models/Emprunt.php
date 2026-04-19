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

    public function jours_retard()
    {
        if ($this->statut === 'retourne') {
            $retard = $this->date_retour_reelle->diffInDays($this->date_retour_prevue);
            return $retard > 0 ? $retard : 0;
        }

        if ($this->date_retour_prevue->isPast()) {
            return $this->date_retour_prevue->diffInDays(now());
        }

        return 0;
    }

    public function montant_penalite()
    {
        $jours = $this->jours_retard();
        $montant = $jours * config('library.penalty_per_day');
        return min($montant, config('library.max_penalty_amount'));
    }

    public function en_retard()
    {
        return $this->jours_retard() > 0;
    }
}

