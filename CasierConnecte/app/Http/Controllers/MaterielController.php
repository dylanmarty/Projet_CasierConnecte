<?php

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
        $Famille_materiel = Famille_materiel::all();
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


        return view('materiel', compact('Famille_materiel', 'Materiel'));
    }

    public function filtrerMateriels(Request $request)
    {
        $familleId = $request->get('familleId');
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

        return response()->json($materiels);
    }

    public function addMateriel(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nomMateriel' => 'required|string|regex:/^[a-zA-ZÀ-ÿ\s]+$/|max:255',
            'imageMateriel' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'duree' => 'required|string|max:255|regex:/^\d+$/',
            'familleMateriel' => 'required|integer|min:1'
        ]);

        // Personnalisation des messages d'erreur
        $validator->setCustomMessages([
            'nomMateriel.regex' => 'Le nom doit contenir uniquement des lettres.',
            'imageMateriel.required' => 'Veuillez sélectionner une image.',
            'imageMateriel.image' => 'Le fichier doit être une image.',
            'imageMateriel.mimes' => 'Seuls les formats jpeg, png, jpg et gif sont autorisés.',
            'duree.regex' => 'La durée doit être composée uniquement de chiffres.',
            'familleMateriel.required' => 'Veuillez sélectionner une famille de matériel.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $nouveauMateriel = new Materiel();
        $nouveauMateriel->nom = $request->input('nomMateriel');

        // Traitement de l'image
        if ($request->hasFile('imageMateriel')) {
            $image = $request->file('imageMateriel');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $imagePath = 'images/materiel/' . $imageName;

            $image->move(public_path('images/materiel'), $imageName);
            $nouveauMateriel->image = $imagePath;
        }

        $nouveauMateriel->duree_emprunt = $request->input('duree');
        $nouveauMateriel->id_famille_materiel = $request->input('familleMateriel');

        $nouveauMateriel->save();
        return redirect('materiel');
    }


    public function updateMateriel(Request $request, $id)
    {
        $Materiel = Materiel::find($id);

        $validator = Validator::make($request->all(), [
            'modifNomMateriel' => 'required|string|regex:/^[a-zA-ZÀ-ÿ\s]+$/|max:255',
            'modifDureeMateriel' => 'required|string|max:255|regex:/^\d+$/',
            'modifFamilleMateriel' => 'required|integer|min:1'
        ]);

        // Personnalisation des messages d'erreur
        $validator->setCustomMessages([
            'modifNomMateriel.regex' => 'Le nom doit contenir uniquement des lettres.',
            'modifDureeMateriel.regex' => 'La durée doit être composée uniquement de chiffres.',
            'modifFamilleMateriel.required' => 'Veuillez sélectionner une famille de matériel.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $Materiel->nom = $request->input('modifNomMateriel');
        $Materiel->duree_emprunt = $request->input('modifDureeMateriel');
        $Materiel->id_famille_materiel = $request->input('modifFamilleMateriel');
        $Materiel->save();

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
