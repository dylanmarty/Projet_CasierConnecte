<?php

//Auteur : Marty Dylan

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\EmpruntService;

class VerifierEmprunts extends Command
{
    // Définition de la signature de la commande
    // 'emprunts:verifier' est le nom de la commande qui sera utilisée dans l'interface de ligne de commande
    protected $signature = 'emprunts:verifier';

    // Description de la commande
    protected $description = 'Vérifie les emprunts en retard';

    // Propriété pour stocker l'instance du service EmpruntService
    protected $empruntService;

    // Le constructeur de la classe
    // Ici, nous injectons le service EmpruntService dans la commande
    public function __construct(EmpruntService $empruntService)
    {
        // Appel du constructeur parent
        parent::__construct();
        // Assignation de l'instance de EmpruntService à la propriété
        $this->empruntService = $empruntService;
    }

    // La méthode handle est exécutée lorsque la commande est appelée
    public function handle()
    {
        // Appel de la méthode verifierEmpruntsEnRetard sur l'instance du service EmpruntService
        $this->empruntService->verifierEmpruntsEnRetard();
        // Affichage d'un message dans la console pour indiquer que la vérification est terminée
        $this->info('Vérification des emprunts terminée.');
    }
}
