<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Livre extends Model
{
    use HasFactory;

    protected $fillable = [
        'titre',
        'auteur',
        'isbn',
        'description',
        'categorie',
        'date_publication',
        'quantite',
        'quantite_disponible',
        'photo',
        'resume',
        'editeur',
    ];

    protected $casts = [
        'date_publication' => 'date',
    ];

    /**
     * Relations
     */

    public function emprunts()
    {
        return $this->hasMany(Emprunt::class);
    }

    public function empruntsCourants()
    {
        return $this->emprunts()->where('statut', 'en_cours');
    }

    /**
     * Accesseurs / Mutateurs
     */

    public function estDisponible()
    {
        return $this->quantite_disponible > 0;
    }

    public function empruntesRestants()
    {
        return $this->quantite - $this->quantite_disponible;
    }
}
