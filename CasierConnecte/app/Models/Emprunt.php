<?php

// Auteur : Dylan Marty

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Emprunt extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'date_emprunt', 'date_retour', 'id_adherent', 'id_materiel'];

    /**
     * Obtient les SMS associés à cet emprunt.
     */
    public function sms(): HasMany
    {
        return $this->hasMany(Sms::class);
    }

    /**
     * Obtient l'adhérent associé à cet emprunt.
     */
    public function adherent(): BelongsTo
    {
        return $this->belongsTo(Adherent::class, 'id_adherent', 'id');
    }

    /**
     * Obtient le matériel associé à cet emprunt.
     */
    public function materiel(): BelongsTo
    {
        return $this->belongsTo(Materiel::class, 'id_materiel', 'id');
    }
}
