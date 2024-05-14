<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Adherent extends Model
{
    use HasFactory;
    public function emprunt(): HasMany
    {
        return $this->hasMany(Emprunt::class);
    }
    public $timestamps = false; // Désactiver les timestamps
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
