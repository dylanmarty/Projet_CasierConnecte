<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class Sms extends Model
{
    use HasFactory;
    protected $fillable = ['message', 'date_envoi', 'id_emprunt'];
    public function emprunt(): BelongsTo
    {
        return $this->belongsTo(Emprunt::class);
    }

}
