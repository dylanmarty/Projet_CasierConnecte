<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Meuble extends Model
{
    use HasFactory;
    public function casier(): HasMany
{
    return $this->hasMany(Casier::class);
}
}
