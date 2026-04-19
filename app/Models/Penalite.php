<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penalite extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'emprunt_id',
        'montant',
        'raison',
        'date_application',
        'payee',
        'date_paiement',
    ];

    protected $casts = [
        'date_application' => 'datetime',
        'date_paiement' => 'datetime',
        'payee' => 'boolean',
    ];

    /**
     * Relations
     */

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function emprunt()
    {
        return $this->belongsTo(Emprunt::class);
    }
}
