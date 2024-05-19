<?php

// Auteur : Dylan Marty

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Adherent extends Model
{
    use HasFactory;

    /**
     * Obtient tous les emprunts associés à cet adhérent.
     */
    public function emprunt(): HasMany
    {
        return $this->hasMany(Emprunt::class);
    }

    /**
     * Désactiver l'horodatage des créations et mises à jour.
     */
    public $timestamps = false;

    /**
     * Les attributs pouvant être assignés en masse.
     */
    protected $fillable = [
        'nom',
        'prenom',
        'classe',
        'date_naissance',
        'num_telephone',
        'num_badge',
        'tag_RFID',
    ];
}
