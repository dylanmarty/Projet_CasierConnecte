<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\EmpruntService;

class VerifierEmprunts extends Command
{
    protected $signature = 'emprunts:verifier';

    protected $description = 'Vérifie les emprunts en retard';

    protected $empruntService;

    public function __construct(EmpruntService $empruntService)
    {
        parent::__construct();
        $this->empruntService = $empruntService;
    }

    public function handle()
    {
        $this->empruntService->verifierEmpruntsEnRetard();
        $this->info('Vérification des emprunts terminée.');
    }
}
