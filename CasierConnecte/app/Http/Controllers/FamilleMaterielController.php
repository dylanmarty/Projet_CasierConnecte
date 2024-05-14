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

class FamilleMaterielController extends Controller
{
    public function getFamille(Request $request)
    {
        $Famille_materiel = Famille_materiel::all();
        return view('familleMateriel', compact('Famille_materiel'));
    }
    public function addFamille(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nomFamille' => 'required|string|regex:/^[a-zA-ZÀ-ÿ\s]+$/|max:255',
        ]);
        // Personnalisation du message d'erreur pour le numéro de téléphone et le numéro de badge
        $validator->setCustomMessages([
            'nomFamille.regex' => 'le nom doit seulement contenir des lettres',
        ]);

        // Vérification de la validation
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $Famille_materiel = new Famille_materiel;
        $Famille_materiel->nom = $request->input('nomFamille');
        $Famille_materiel->save();
        return redirect('familleMateriel');
    }

    public function deleteAllFamille()
    {
        // Désactiver la vérification des clés étrangères
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        $directory = 'images/materiel';
        Storage::deleteDirectory($directory);

        Famille_materiel::truncate();
        Materiel::truncate();
        Sms::truncate();
        Emprunt::truncate();

        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        return redirect('familleMateriel')->with('success', 'Tous les adhérents ont été supprimés avec succès.');
    }

    public function updateFamille(Request $request, $id)
    {
        $Famille_materiel = Famille_materiel::find($id);

        $validator = Validator::make($request->all(), [
            'modifNomFamille' => 'required|string|regex:/^[a-zA-ZÀ-ÿ\s]+$/|max:255',
        ]);
        $validator->setCustomMessages([
            'modifNomFamille.regex' => 'le nom doit seulement contenir des lettres',
        ]);

        if ($validator->fails()) {
            return redirect('familleMateriel')->withErrors($validator)->withInput();
        }

        $Famille_materiel->nom = $request->input('modifNomFamille');
        $Famille_materiel->save();

        return redirect('familleMateriel');
    }
    public function deleteFamille($id)
    {

        $familleMateriel = Famille_materiel::findOrFail($id);
        $materiels = Materiel::where('id_famille_materiel', $id)->get();

        foreach ($materiels as $materiel) {
            if ($materiel->image) {
                unlink(public_path($materiel->image));
            }
            $materiel->delete();
        }
        $familleMateriel->delete();
        return redirect('familleMateriel');
    }

}
