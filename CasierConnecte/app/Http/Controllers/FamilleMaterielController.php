<?php

// Auteur : Dylan Marty

namespace App\Http\Controllers;

use App\Models\Materiel;
use App\Models\Famille_materiel;
use App\Models\Sms;
use App\Models\Emprunt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class FamilleMaterielController extends Controller
{
    /**
     * Affiche la liste des familles de matériel.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function getFamille(Request $request)
    {
        // Récupérer toutes les familles de matériel
        $Famille_materiel = Famille_materiel::all();

        // Retourner la vue 'familleMateriel' avec les données des familles de matériel
        return view('familleMateriel', compact('Famille_materiel'));
    }

    /**
     * Ajoute une nouvelle famille de matériel.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function addFamille(Request $request)
    {
        // Valider les données du formulaire
        $validator = Validator::make($request->all(), [
            'nomFamille' => 'required|string|regex:/^[a-zA-ZÀ-ÿ\s]+$/|max:255',
        ]);

        // Personnalisation du message d'erreur pour le nom de la famille
        $validator->setCustomMessages([
            'nomFamille.regex' => 'Le nom doit seulement contenir des lettres.',
        ]);

        // Vérification de la validation
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Création d'une nouvelle instance de Famille_materiel
        $familleMateriel = new Famille_materiel;
        $familleMateriel->nom = $request->input('nomFamille');
        $familleMateriel->save();

        // Redirection vers la page 'familleMateriel' avec un message de succès
        return redirect('familleMateriel');
    }

    /**
     * Supprime toutes les familles de matériel.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteAllFamille()
    {
        // Désactiver la vérification des clés étrangères
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        // Supprimer le répertoire des images de matériel
        $directory = 'images/materiel';
        Storage::deleteDirectory($directory);

        // Supprimer toutes les données liées aux familles de matériel, matériels, SMS et emprunts
        Famille_materiel::truncate();
        Materiel::truncate();
        Sms::truncate();
        Emprunt::truncate();

        // Réactiver la vérification des clés étrangères
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        // Redirection vers la page 'familleMateriel' avec un message de succès
        return redirect('familleMateriel')->with('success', 'Toutes les familles de matériel ont été supprimées avec succès.');
    }

    /**
     * Met à jour une famille de matériel existante.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateFamille(Request $request, $id)
    {
        // Récupérer la famille de matériel à mettre à jour
        $familleMateriel = Famille_materiel::find($id);

        // Valider les données du formulaire
        $validator = Validator::make($request->all(), [
            'modifNomFamille' => 'required|string|regex:/^[a-zA-ZÀ-ÿ\s]+$/|max:255',
        ]);

        // Personnalisation du message d'erreur pour le nom de la famille
        $validator->setCustomMessages([
            'modifNomFamille.regex' => 'Le nom doit seulement contenir des lettres.',
        ]);

        // Vérification de la validation
        if ($validator->fails()) {
            return redirect('familleMateriel')->withErrors($validator)->withInput();
        }

        // Mise à jour du nom de la famille de matériel
        $familleMateriel->nom = $request->input('modifNomFamille');
        $familleMateriel->save();

        // Redirection vers la page 'familleMateriel'
        return redirect('familleMateriel');
    }

    /**
     * Supprime une famille de matériel et tous les matériels associés.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteFamille($id)
    {
        // Récupérer la famille de matériel à supprimer
        $familleMateriel = Famille_materiel::findOrFail($id);

        // Récupérer tous les matériels associés à cette famille
        $materiels = Materiel::where('id_famille_materiel', $id)->get();

        // Supprimer chaque matériel et son image le cas échéant
        foreach ($materiels as $materiel) {
            if ($materiel->image) {
                unlink(public_path($materiel->image));
            }
            $materiel->delete();
        }

        // Supprimer la famille de matériel
        $familleMateriel->delete();

        // Redirection vers la page 'familleMateriel'
        return redirect('familleMateriel');
    }
}
