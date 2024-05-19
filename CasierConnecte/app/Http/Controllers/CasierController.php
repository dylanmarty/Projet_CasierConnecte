<?php

// Auteur: Dylan Marty
    
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Casier;
use App\Models\Materiel;

class CasierController extends Controller
{
    /**
     * Affiche la liste des casiers avec les matériels associés.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Récupérer tous les casiers
        $casiers = Casier::all();

        // Récupérer les matériels associés à chaque casier
        foreach ($casiers as $casier) {
            $casier->materiels = Materiel::where('id_casier', $casier->id)->get();
        }

        // Passer les données des casiers avec les matériels associés à la vue 'welcome'
        return view('welcome', compact('casiers'));
    }
}
