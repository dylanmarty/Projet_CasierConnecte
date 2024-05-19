<?php

// Auteur : Dylan Marty

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Sms extends Model
{
    use HasFactory;

    /**
     * Obtient l'emprunt associé à ce SMS.
     */
    public function emprunt(): BelongsTo
    {
        return $this->belongsTo(Emprunt::class);
    }

    /**
     * Les attributs qui sont assignables en masse.
     *
     * @var array
     */
    protected $fillable = ['message', 'date_envoi', 'id_emprunt'];
}
