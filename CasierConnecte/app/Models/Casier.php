<?php

// Auteur : Dylan Marty

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Casier extends Model
{
    use HasFactory;

    /**
     * Obtient le meuble auquel ce casier appartient.
     */
    public function meuble(): BelongsTo
    {
        return $this->belongsTo(Meuble::class);
    }

    /**
     * Obtient le matériel associé à ce casier.
     */
    public function materiel(): HasOne
    {
        return $this->hasOne(Materiel::class);
    }
}
