<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Casier;
use App\Models\Materiel;

class CasierController extends Controller
{
    public function index()
    {
        // Récupérer tous les casiers
        $casiers = Casier::all();

        // Récupérer les matériels associés à chaque casier
        foreach ($casiers as $casier) {
            $casier->materiels = Materiel::where('id_casier', $casier->id)->get();
        }

        return view('welcome', compact('casiers'));
    }
}
