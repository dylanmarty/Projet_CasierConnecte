<?php

// Auteur : Dylan Marty

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Famille_materiel extends Model
{
    use HasFactory;

    public $timestamps = false; // Désactiver les timestamps

    protected $fillable = ['id','nom'];

    /**
     * Obtient les matériels associés à cette famille de matériel.
     */
    public function materiel(): HasMany
    {
        return $this->hasMany(Materiel::class);
    }
}
