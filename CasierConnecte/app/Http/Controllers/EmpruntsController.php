<?php

// Auteur : Dylan Marty

namespace App\Http\Controllers;

use App\Services\EmpruntService;
use App\Services\SmsService;
use App\Models\Emprunt;
use App\Models\Materiel;
use App\Models\Adherent;
use Illuminate\Http\Request;

class EmpruntsController extends Controller
{
    /**
     * Affiche la liste des emprunts avec les détails du matériel et de l'adhérent.
     *
     * @return \Illuminate\View\View
     */
    public function getEmprunts()
    {
        // Récupère tous les emprunts avec les relations 'materiel' et 'adherent'
        $emprunts = Emprunt::with(['materiel', 'adherent'])->get();
        
        // Retourne la vue 'historique' avec la liste des emprunts
        return view('historique', ['emprunts' => $emprunts]);
    }

    /**
     * Vérifie les emprunts en retard en utilisant le service EmpruntService.
     *
     * @param EmpruntService $empruntService
     * @return void
     */
    public function index(EmpruntService $empruntService)
    {
        // Utilise le service pour vérifier les emprunts en retard
        $empruntService->verifierEmpruntsEnRetard();
    }

    /**
     * Envoie un message SMS à l'adhérent associé à un emprunt donné.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function sendMessage(Request $request)
    {
        // Récupère l'ID de l'emprunt et le message du formulaire de la requête
        $empruntId = $request->input('empruntId');
        $message = $request->input('message');

        // Trouve l'emprunt correspondant à l'ID
        $emprunt = Emprunt::find($empruntId);

        // Récupère le numéro de téléphone de l'adhérent associé à l'emprunt
        $phoneNumber = $emprunt->adherent->num_telephone;

        // Initialise le service SMS et envoie le message
        $smsService = new SmsService();
        $smsService->sendSms($phoneNumber, $message);

        // Redirige vers la page précédente avec un message de succès
        return redirect()->back()->with('success', 'Message envoyé avec succès!');
    }
}
