<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Materiel extends Model
{
    use HasFactory;
    public $timestamps = false; // Désactiver les timestamps
    protected $fillable = ['nom', 'image', 'etat', 'duree_emprunt', 'id_famille_materiel', 'id_casier'];
    public function emprunt(): HasMany
{
    return $this->hasMany(Emprunt::class);
}
public function famille_materiel(): BelongsTo
{
    return $this->belongsTo(Famille_materiel::class);
}
public function casier(): BelongsTo
{
    return $this->belongsTo(Casier::class, 'id_meuble', 'id');
}
}
