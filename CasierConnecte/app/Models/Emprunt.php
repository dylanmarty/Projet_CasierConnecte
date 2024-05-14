<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Emprunt extends Model
{
    use HasFactory;
    protected $fillable = ['id', 'date_emprunt', 'date_retour', 'id_adherent', 'id_materiel'];

    public function sms(): HasMany
    {
        return $this->hasMany(Sms::class);
    }
    public function adherent(): BelongsTo
    {
        return $this->belongsTo(Adherent::class, 'id_adherent', 'id');
    }
    public function materiel(): BelongsTo
    {
        return $this->belongsTo(Materiel::class, 'id_materiel', 'id');
    }

}
