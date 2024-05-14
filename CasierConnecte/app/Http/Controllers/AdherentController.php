<?php

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

    public function getAdherent(Request $request)
    {
        $adherents = Adherent::all();
        return view('adherent', ['adherents' => $adherents]);
    }
    function addAdherent(Request $request)
    {
        $adherent = new Adherent;

        $adherent->nom = $request->input('nom');
        $adherent->prenom = $request->input('prenom');
        $adherent->classe = $request->input('classe');
        $adherent->date_naissance = $request->input('naissance');
        $adherent->num_telephone = $request->input('numTelephone');
        $adherent->num_badge = $request->input('numBadge');
        $adherent->save();

        return redirect('adherent');

    }
    public function deleteAdherent($id)
    {
        $adherent = Adherent::find($id);
        $adherent->delete();

        return redirect('adherent')->with('success', 'Adhérent supprimé avec succès.');
    }
    public function deleteAllAdherent()
    {
            // Désactiver la vérification des clés étrangères
            DB::statement('SET FOREIGN_KEY_CHECKS=0');

            Sms::truncate();
            Emprunt::truncate();
            Adherent::truncate();

            DB::statement('SET FOREIGN_KEY_CHECKS=1');

            return redirect('adherent')->with('success', 'Tous les adhérents ont été supprimés avec succès.');
    }
    public function updateAdherent(Request $request, $id)
    {
        $adherent = Adherent::find($id);

        $adherent->nom = $request->input('modifNom');
        $adherent->prenom = $request->input('modifPrenom');
        $adherent->classe = $request->input('modifClasse');
        $adherent->date_naissance = $request->input('modifNaissance');
        $adherent->num_telephone = $request->input('modifNumTelephone');
        $adherent->num_badge = $request->input('modifNumBadge');
        $adherent->save();

        return redirect('adherent');
    }

    public function importAdherent(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'csvFile' => 'required|file|mimetypes:text/csv,text/plain'
        ]);

        $validator->setCustomMessages([
            'csvFile.regex' => 'Mauvais format de fichier ',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $file = $request->file('csvFile');
        Excel::import(new AdherentsImport, $file);

        return redirect()->back()->with('success', 'Adhérents importés avec succès.');
    }
}
