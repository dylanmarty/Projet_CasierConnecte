<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Casier extends Model
{
    use HasFactory;
    public function meuble(): BelongsTo
{
    return $this->belongsTo(Meuble::class);
}
public function materiel(): HasOne
{
    return $this->hasOne(Materiel::class);
}
}
