<?php


// Auteur: Dylan Marty

namespace App\Http\Controllers;

use App\Models\Adherent;
use App\Models\Emprunt;
use App\Models\Sms;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Imports\AdherentsImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;

class AdherentController extends Controller
{
    // Méthode pour récupérer tous les adhérents
    public function getAdherent(Request $request)
    {
        $adherents = Adherent::all(); // Récupérer tous les adhérents depuis la base de données
        return view('adherent', ['adherents' => $adherents]); // Retourner la vue avec la liste des adhérents
    }

    // Méthode pour ajouter un nouvel adhérent
    function addAdherent(Request $request)
    {
        $adherent = new Adherent; // Créer une nouvelle instance d'Adherent

        // Affecter les valeurs des champs de l'adhérent depuis la requête
        $adherent->nom = $request->input('nom');
        $adherent->prenom = $request->input('prenom');
        $adherent->classe = $request->input('classe');
        $adherent->date_naissance = $request->input('naissance');
        $adherent->num_telephone = $request->input('numTelephone');
        $adherent->num_badge = $request->input('numBadge');
        $adherent->save(); // Sauvegarder l'adhérent dans la base de données

        return redirect('adherent'); // Rediriger vers la liste des adhérents
    }

    // Méthode pour supprimer un adhérent spécifique
    public function deleteAdherent($id)
    {
        $adherent = Adherent::find($id); // Trouver l'adhérent par son identifiant
        $adherent->delete(); // Supprimer l'adhérent de la base de données

        return redirect('adherent')->with('success', 'Adhérent supprimé avec succès.'); // Rediriger avec un message de succès
    }

    // Méthode pour supprimer tous les adhérents
    public function deleteAllAdherent()
    {
        // Désactiver la vérification des clés étrangères pour permettre la suppression en cascade
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        // Supprimer toutes les entrées dans les tables associées (Sms, Emprunt) ainsi que les adhérents
        Sms::truncate();
        Emprunt::truncate();
        Adherent::truncate();

        // Réactiver la vérification des clés étrangères
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        return redirect('adherent')->with('success', 'Tous les adhérents ont été supprimés avec succès.'); // Rediriger avec un message de succès
    }

    // Méthode pour mettre à jour les informations d'un adhérent
    public function updateAdherent(Request $request, $id)
    {
        $adherent = Adherent::find($id); // Trouver l'adhérent par son identifiant

        // Mettre à jour les champs de l'adhérent avec les nouvelles valeurs depuis la requête
        $adherent->nom = $request->input('modifNom');
        $adherent->prenom = $request->input('modifPrenom');
        $adherent->classe = $request->input('modifClasse');
        $adherent->date_naissance = $request->input('modifNaissance');
        $adherent->num_telephone = $request->input('modifNumTelephone');
        $adherent->num_badge = $request->input('modifNumBadge');
        $adherent->save(); // Sauvegarder les modifications dans la base de données

        return redirect('adherent'); // Rediriger vers la liste des adhérents
    }

    // Méthode pour importer des adhérents depuis un fichier CSV
    public function importAdherent(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'csvFile' => 'required|file|mimetypes:text/csv,text/plain'
        ]);

        $validator->setCustomMessages([
            'csvFile.regex' => 'Mauvais format de fichier ',
        ]);

        // Valider le fichier CSV
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $file = $request->file('csvFile'); // Récupérer le fichier CSV depuis la requête
        Excel::import(new AdherentsImport, $file); // Importer les adhérents depuis le fichier CSV

        return redirect()->back()->with('success', 'Adhérents importés avec succès.'); // Rediriger avec un message de succès
    }
}
