<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Materiel extends Model
{
    use HasFactory;

    // Désactiver les timestamps automatiques (created_at, updated_at)
    public $timestamps = false;

    // Définir les attributs pouvant être remplis en masse
    protected $fillable = ['nom', 'image', 'etat', 'duree_emprunt', 'id_famille_materiel', 'id_casier'];

    // Définir la relation "un à plusieurs" avec le modèle Emprunt

    public function emprunt(): HasMany
    {
        return $this->hasMany(Emprunt::class);
    }

    
    // Définir la relation "plusieurs à un" avec le modèle Famille_materiel
     
    public function famille_materiel(): BelongsTo
    {
        return $this->belongsTo(Famille_materiel::class);
    }

    /**
     * Définir la relation "plusieurs à un" avec le modèle Casier
     * Lier id_casier dans Materiel avec id dans Casier
     */
    public function casier(): BelongsTo
    {
        return $this->belongsTo(Casier::class, 'id_casier', 'id');
    }
}
