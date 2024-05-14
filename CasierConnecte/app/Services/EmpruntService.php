<?php

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

    public function verifierEmpruntsEnRetard()
    {
        $emprunts = Emprunt::all();

        foreach ($emprunts as $emprunt) {
            $dateRetourPrevue = Carbon::parse($emprunt->date_limite);

            if ($dateRetourPrevue === false) {
                continue;
            }

            if ($dateRetourPrevue->isPast() && $emprunt->date_retour === null) {
                $phoneNumber = $emprunt->adherent->num_telephone;
                $materielNom = $emprunt->adherent->name;
                $message = 'Bonjour, vous avez oublié de rendre votre matériel : "' . $materielNom . '". Merci de le retourner dès que possible. Ceci est un message automatique. Merci de ne pas y répondre.';
                $this->smsService->sendSms($phoneNumber, $message);
            }
        }
    }

}
