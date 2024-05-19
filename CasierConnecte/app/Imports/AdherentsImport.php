<?php

// Auteur : Dylan Marty

namespace App\Imports;

use App\Models\Adherent;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class AdherentsImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {

        if (stripos($row['categorie'], 'Adhérent') !== false) {

            $numBadge = $row['n_de_badge'];

            // Vérifie si l'adhérent existe déjà dans la base de données
            $existingAdherent = Adherent::where('num_badge', $numBadge)->first();

            // Si l'adhérent existe déjà, ne l'importe pas de nouveau
            if ($existingAdherent) {
                return null;
            } elseif (empty($row['nom']) || empty($row['prenom']) ||
                empty($row['classe']) || empty($row['date_de_naissance']) ||
                empty($row['tel_mobile']) ||  empty($row['n_de_badge'])) {
                return null;
            } else {
                $nom = $row['nom'];
                $prenom = $row['prenom'];
                $classe = $row['classe'];
                $date_naissance = $row['date_de_naissance'];
                $num_telephone = $this->formatPhoneNumber($row['tel_mobile']);
                $num_badge = $row['n_de_badge'];

                return new Adherent([
                    'nom' => $nom,
                    'prenom' => $prenom,
                    'classe' => $classe,
                    'date_naissance' => $date_naissance,
                    'num_telephone' => $num_telephone,
                    'num_badge' => $num_badge,
                ]);
            }
        }
        return null;
    }

    private function formatPhoneNumber($phoneNumber)
    {
        // Vérifie si le numéro commence par '33'
        if (substr($phoneNumber, 0, 2) === '33') {
            // Remplace '33' par '0'
            return '0' . substr($phoneNumber, 2);
        } elseif (strlen($phoneNumber) === 9) {
            // Si le numéro ne commence pas par '0' et a une longueur de 9 chiffres, ajoute '0' au début
            return '0' . $phoneNumber;
        } else {
            return $phoneNumber;
        }
    }
}
