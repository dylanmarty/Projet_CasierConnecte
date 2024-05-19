<?php

// Auteur : Dylan Marty

namespace App\Services;

use phpseclib3\Net\SSH2;

class SmsService
{
    protected $ssh;

    public function __construct()
    {
        // Initialise la connexion SSH avec les informations d'authentification de l'environnement
        $this->ssh = new SSH2(env('RASPBERRY_PI_IP'));

        // Vérifie si la connexion SSH a réussi
        if (!$this->ssh->login(env('PI_USERNAME'), env('PI_PASSWORD'))) {
            // Lance une exception en cas d'échec de la connexion
            throw new \Exception('Échec de la connexion via SSH');
        }
    }

    /**
     * Envoie un SMS en utilisant la commande gammu-smsd-inject.
     *
     * @param string $phoneNumber Le numéro de téléphone du destinataire.
     * @param string $message Le message à envoyer.
     * @return mixed Le résultat de l'exécution de la commande SSH.
     */
    public function sendSms($phoneNumber, $message)
    {
        // Construit la commande pour l'injection du SMS
        $command = 'gammu-smsd-inject TEXT ' . $phoneNumber . ' -text "' . $message . '"';

        // Exécute la commande SSH et récupère la sortie
        $output = $this->ssh->exec($command);

        // Retourne la sortie de la commande
        return $output;
    }
}
