<?php

// Auteur : Dylan Marty

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Les attributs qui sont assignables en masse.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'droit',
    ];

    /**
     * Les attributs qui sont cachés pour la sérialisation.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Obtient les attributs qui doivent être transformés.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Vérifie si l'utilisateur est un super-utilisateur.
     *
     * @return bool
     */
    public function isSuperUtilisateur(): bool
    {
        return $this->droit === 'Super-Utilisateur';
    }

    /**
     * Vérifie si l'utilisateur est un super-utilisateur ou un responsable.
     *
     * @return bool
     */
    public function isSuperUtilisateurOrResponsable(): bool
    {
        return $this->droit === 'Super-Utilisateur' || $this->droit === 'Responsable';
    }
}
