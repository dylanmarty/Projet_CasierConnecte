<?php

// Auteur : Dylan Marty

namespace App\Services;

use App\Models\Emprunt;
use App\Services\SmsService;
use Carbon\Carbon;

class EmpruntService
{
    protected $smsService;

    public function __construct(SmsService $smsService)
    {
        $this->smsService = $smsService;
    }

    /**
     * Vérifie les emprunts en retard et envoie des SMS aux adhérents concernés.
     */
    public function verifierEmpruntsEnRetard()
    {
        // Récupère tous les emprunts
        $emprunts = Emprunt::all();

        foreach ($emprunts as $emprunt) {
            // Récupère la date de retour prévue de l'emprunt
            $dateRetourPrevue = Carbon::parse($emprunt->date_limite);

            // Vérifie si la date de retour prévue est passée et si l'emprunt n'a pas encore été retourné
            if ($dateRetourPrevue->isPast() && $emprunt->date_retour === null) {
                // Récupère le numéro de téléphone de l'adhérent
                $phoneNumber = $emprunt->adherent->num_telephone;

                // Récupère le nom du matériel emprunté
                $materielNom = $emprunt->materiel->nom;

                // Crée le message SMS
                $message = 'Bonjour, vous avez oublié de rendre votre matériel : "' . $materielNom . '". Merci de le retourner dès que possible. Ceci est un message automatique. Merci de ne pas y répondre.';

                // Envoie le SMS
                $this->smsService->sendSms($phoneNumber, $message);
            }
        }
    }
}
