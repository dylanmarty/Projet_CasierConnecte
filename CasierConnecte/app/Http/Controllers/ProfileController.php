<?php

// Auteur : Benjamin Crespeau

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Affiche le formulaire de profil de l'utilisateur.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Met à jour les informations de profil de l'utilisateur.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        // Met à jour les informations du profil avec les données validées
        $request->user()->fill($request->validated());

        // Réinitialise la vérification de l'e-mail si l'e-mail a été modifié
        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        // Enregistre les modifications du profil
        $request->user()->save();

        // Redirige vers la page de modification du profil avec un message de succès
        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Supprime le compte de l'utilisateur.
     */
    public function destroy(Request $request): RedirectResponse
    {
        // Valide le mot de passe de l'utilisateur pour la suppression du compte
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        // Récupère l'utilisateur actuel
        $user = $request->user();

        // Déconnecte l'utilisateur
        Auth::logout();

        // Supprime le compte de l'utilisateur
        $user->delete();

        // Invalide la session et régénère le jeton de session
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Redirige vers la page d'accueil après la suppression du compte
        return Redirect::to('/');
    }
}
