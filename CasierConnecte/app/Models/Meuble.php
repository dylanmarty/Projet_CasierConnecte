<?php

// Auteur : Dylan Marty

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Meuble extends Model
{
    use HasFactory;

    /**
     * Obtient les casiers associés à ce meuble.
     */
    public function casier(): HasMany
    {
        return $this->hasMany(Casier::class);
    }
}
