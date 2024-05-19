<?php

// Auteur : Dylan Marty

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable; // Importer cette classe

class Utilisateur extends Authenticatable // Étendre la classe Authenticatable
{
    use HasFactory;

    // Définir les colonnes remplissables
    protected $fillable = ['identifiant', 'password', 'email'];
}
