<?php

// Auteur : Dylan Marty

namespace App\Http\Controllers;

use App\Services\SmsService;
use Illuminate\Http\Request;
use App\Models\User;

class UsersController extends Controller
{
    /**
     * Affiche la liste des utilisateurs.
     */
    public function getUtilisateurs()
    {
        // Récupère tous les utilisateurs
        $users = User::all();

        // Retourne la vue 'utilisateur' avec la liste des utilisateurs
        return view('utilisateur', ['users' => $users]);
    }

    /**
     * Met à jour les informations d'un utilisateur.
     */
    public function updateUtilisateur(Request $request, $id)
    {
        // Récupère l'utilisateur à mettre à jour
        $user = User::find($id);

        // Met à jour le droit de l'utilisateur
        $user->droit = $request->input('modifDroit');
        $user->save();

        // Redirige vers la page des utilisateurs
        return redirect('utilisateur');
    }

    /**
     * Supprime un utilisateur.
     */
    public function deleteUtilisateur($id)
    {
        // Récupère l'utilisateur à supprimer
        $user = User::find($id);

        // Supprime l'utilisateur
        $user->delete();

        // Redirige vers la page des utilisateurs avec un message de succès
        return redirect('utilisateur')->with('success', 'Adhérent supprimé avec succès.');
    }

    /**
     * Supprime tous les utilisateurs (sauf les super utilisateurs).
     */
    public function deleteAllUtilisateur()
    {
        // Supprime tous les utilisateurs qui ne sont pas des super utilisateurs
        User::where('droit', '!=', 'Super-Utilisateur')->delete();

        // Redirige vers la page des utilisateurs avec un message de succès
        return redirect('utilisateur')->with('success', 'Tous les utilisateurs (sauf les super utilisateurs) ont été supprimés avec succès.');
    }
}
