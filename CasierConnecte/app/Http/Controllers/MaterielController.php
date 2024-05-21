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
use App\Services\SmsService;

class MaterielController extends Controller
{
    public function getMateriel(Request $request)
    {
        // Récupérer toutes les familles de matériel
        $Famille_materiel = Famille_materiel::all();

        // Récupérer tous les matériels avec leurs détails
        $Materiel = Materiel::select(
            "materiels.id",
            "materiels.nom",
            "materiels.image",
            "materiels.etat",
            "materiels.duree_emprunt",
            "famille_materiels.nom as famille_materiels_nom"
        )
            ->join("famille_materiels", "famille_materiels.id", "=", "materiels.id_famille_materiel")
            ->get();

        // Retourner la vue 'materiel' avec les données récupérées
        return view('materiel', compact('Famille_materiel', 'Materiel'));
    }

    public function filtrerMateriels(Request $request)
    {
        // Récupérer l'ID de la famille de matériel
        $familleId = $request->get('familleId');

        // Filtrer les matériels en fonction de l'ID de la famille de matériel
        $materiels = Materiel::select(
            "materiels.id",
            "materiels.nom",
            "materiels.image",
            "materiels.etat",
            "materiels.duree_emprunt",
            "famille_materiels.nom as famille_materiels_nom"
        )
            ->join("famille_materiels", "famille_materiels.id", "=", "materiels.id_famille_materiel")
            ->where("famille_materiels.id", $familleId)
            ->get();

        // Retourner les matériels filtrés sous forme de réponse JSON
        return response()->json($materiels);
    }

    public function addMateriel(Request $request)
    {
        // Valider les données du formulaire
        $validator = Validator::make($request->all(), [
            'nomMateriel' => 'required|string|regex:/^[a-zA-ZÀ-ÿ\s]+$/|max:255',
            'imageMateriel' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'duree' => 'required|string|max:255|regex:/^\d+$/',
            'familleMateriel' => 'required|integer|min:1'
        ]);

        // Personnaliser les messages d'erreur
        $validator->setCustomMessages([
            'nomMateriel.regex' => 'Le nom doit contenir uniquement des lettres.',
            'imageMateriel.required' => 'Veuillez sélectionner une image.',
            'imageMateriel.image' => 'Le fichier doit être une image.',
            'imageMateriel.mimes' => 'Seuls les formats jpeg, png, jpg et gif sont autorisés.',
            'duree.regex' => 'La durée doit être composée uniquement de chiffres.',
            'familleMateriel.required' => 'Veuillez sélectionner une famille de matériel.',
        ]);

        // Rediriger avec les erreurs de validation si nécessaire
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Créer un nouveau matériel
        $nouveauMateriel = new Materiel();
        $nouveauMateriel->nom = $request->input('nomMateriel');

        // Gérer l'image associée au matériel
        if ($request->hasFile('imageMateriel')) {
            $image = $request->file('imageMateriel');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $imagePath = 'images/materiel/' . $imageName;

            $image->move(public_path('images/materiel'), $imageName);
            $nouveauMateriel->image = $imagePath;
        }

        // Enregistrer les autres détails du matériel
        $nouveauMateriel->duree_emprunt = $request->input('duree');
        $nouveauMateriel->id_famille_materiel = $request->input('familleMateriel');
        $nouveauMateriel->save();

        // Rediriger avec succès vers la page 'materiel'
        return redirect('materiel');
    }


    public function updateMateriel(Request $request, $id)
    {
        // Trouver le matériel à mettre à jour
        $Materiel = Materiel::find($id);

        // Valider les données du formulaire
        $validator = Validator::make($request->all(), [
            'modifNomMateriel' => 'required|string|regex:/^[a-zA-ZÀ-ÿ\s]+$/|max:255',
            'modifDureeMateriel' => 'required|string|max:255|regex:/^\d+$/',
            'modifFamilleMateriel' => 'required|integer|min:1'
        ]);

        // Personnaliser les messages d'erreur
        $validator->setCustomMessages([
            'modifNomMateriel.regex' => 'Le nom doit contenir uniquement des lettres.',
            'modifDureeMateriel.regex' => 'La durée doit être composée uniquement de chiffres.',
            'modifFamilleMateriel.required' => 'Veuillez sélectionner une famille de matériel.',
        ]);

        // Rediriger avec les erreurs de validation si nécessaire
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Mettre à jour les détails du matériel
        $Materiel->nom = $request->input('modifNomMateriel');
        $Materiel->duree_emprunt = $request->input('modifDureeMateriel');
        $Materiel->id_famille_materiel = $request->input('modifFamilleMateriel');
        $Materiel->save();

        // Rediriger avec succès vers la page 'materiel'
        return redirect('materiel');
    }


    public function deleteMateriel($id)
    {
        $Materiel = Materiel::find($id);
        $Materiel->delete();
        $ancienCheminImage = $Materiel->image;
        if (file_exists($ancienCheminImage)) {
            unlink($ancienCheminImage);
        }

        return redirect('materiel');
    }

    public function deleteAllMateriel()
    {
        // Désactiver la vérification des clés étrangères
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        $directory = 'images/materiel';
        Storage::deleteDirectory($directory);

        Materiel::truncate();
        Sms::truncate();
        Emprunt::truncate();

        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        return redirect('materiel')->with('success', 'Tous les adhérents ont été supprimés avec succès.');
    }

}
