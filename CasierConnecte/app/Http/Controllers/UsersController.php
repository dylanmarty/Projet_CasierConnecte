<?php

namespace App\Http\Controllers;

use App\Services\SmsService;

use Illuminate\Http\Request;
use App\Models\User;

class UsersController extends Controller
{
    public function getUtilisateurs()
    {
        $users = User::all();
        return view('utilisateur', ['users' => $users]);
    }
    public function updateUtilisateur(Request $request, $id)
    {
        $users = User::find($id);
        $users->droit = $request->input('modifDroit');
        $users->save();

        return redirect('utilisateur');
    }

    public function deleteUtilisateur($id)
    {
        $users = User::find($id);
        $users->delete();

        return redirect('utilisateur')->with('success', 'Adhérent supprimé avec succès.');
    }
    public function deleteAllUtilisateur()
    {
        User::where('droit', '!=', 'Super-Utilisateur')->delete();
        return redirect('utilisateur')->with('success', 'Tous les utilisateurs (sauf les super utilisateurs) ont été supprimés avec succès.');
    }


}
