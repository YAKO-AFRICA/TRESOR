<?php

namespace App\Imports;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToArray;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Validators\Failure;

class AssuresImport implements ToArray, WithHeadingRow, WithValidation, SkipsOnFailure
{
    private $data = [];
    private $erreurs = [];
    private $rowIndex = 0;

    public function array(array $array)
    {
        Log::info('Début de l\'importation des assurés - Nombre de lignes: ' . count($array));
        
        foreach ($array as $row) {
            $this->rowIndex++;
            
            // Vérifier les champs obligatoires - Utiliser les noms de colonnes du fichier
            if (empty($row['matricule']) || empty($row['nom']) || empty($row['prenom'])) {
                $this->erreurs[] = [
                    'ligne' => $this->rowIndex + 1,
                    'message' => 'Matricule, nom et prénoms sont obligatoires',
                    'data' => $row
                ];
                continue;
            }

            // Nettoyer et formater les données avec les bons noms de colonnes
            $assure = [
                'matricule' => trim($row['matricule'] ?? ''),
                'genre' => isset($row['genre']) ? strtoupper(trim($row['genre'])) : null,
                'nom' => trim($row['nom'] ?? ''),
                'prenoms' => trim($row['prenom'] ?? ''),
                'date_naissance' => $this->formatDate($row['date_naissance'] ?? null),
                'lieu_naissance' => trim($row['lieu_naissance'] ?? ''),
                'numero_tel' => trim($row['numero_telephone'] ?? ''),
                'num_what' => trim($row['numero_whatsapp'] ?? ''),
                'lieu_residence' => trim($row['lieu_residence'] ?? ''),
                'situation_matrimoniale' => trim($row['situation_matrimoniale'] ?? ''),
                'email' => trim($row['adresse_electronique'] ?? ''),
                'num_cni' => trim($row['numero_cni'] ?? ''),
                'num_nni' => trim($row['numero_nni'] ?? ''),
                'fonction' => trim($row['fonction'] ?? ''),
                'secteur_activite' => trim($row['secteur_activite'] ?? ''),
                'employeur' => trim($row['employeur'] ?? ''),
                'nom_urgence' => trim($row['nom_personne_a_contacter'] ?? ''),
                'num_urgence' => trim($row['numero_pers_a_contacter'] ?? '')
            ];

            // Validation des dates
            if ($assure['date_naissance'] === null && !empty($row['date_naissance'])) {
                $this->erreurs[] = [
                    'ligne' => $this->rowIndex + 1,
                    'message' => 'Format de date de naissance invalide: ' . $row['date_naissance'],
                    'data' => $row
                ];
                continue;
            }

            $this->data[] = $assure;
        }
        
        Log::info('Assurés valides: ' . count($this->data) . ', Erreurs: ' . count($this->erreurs));
    }

    public function rules(): array
    {
        return [
            'matricule' => 'required',
            'nom' => 'required',
            'prenom' => 'required',
        ];
    }

    public function onFailure(Failure ...$failures)
    {
        foreach ($failures as $failure) {
            $this->erreurs[] = [
                'ligne' => $failure->row(),
                'message' => $failure->errors()[0],
                'data' => $failure->values()
            ];
        }
    }

    public function getData()
    {
        return $this->data;
    }

    public function getErreurs()
    {
        return $this->erreurs;
    }

    private function formatDate($date)
    {
        if (empty($date)) {
            return null;
        }

        // Si c'est une date Excel (nombre)
        if (is_numeric($date)) {
            $timestamp = ($date - 25569) * 86400;
            return date('Y-m-d', $timestamp);
        }

        // Si c'est une chaîne de caractères
        try {
            // Nettoyer la date
            $date = trim($date);
            
            // Gérer le format JJ/MM/AAAA
            if (strpos($date, '/') !== false) {
                $parts = explode('/', $date);
                if (count($parts) === 3) {
                    // Vérifier si c'est JJ/MM/AAAA ou MM/JJ/AAAA
                    if (strlen($parts[0]) == 2 && strlen($parts[1]) == 2 && strlen($parts[2]) == 4) {
                        return $parts[2] . '-' . str_pad($parts[1], 2, '0', STR_PAD_LEFT) . '-' . str_pad($parts[0], 2, '0', STR_PAD_LEFT);
                    }
                }
            }
            
            // Essayer de parser la date
            $timestamp = strtotime($date);
            if ($timestamp !== false) {
                return date('Y-m-d', $timestamp);
            }
            
            return null;
        } catch (\Exception $e) {
            Log::warning('Erreur de formatage de date: ' . $date . ' - ' . $e->getMessage());
            return null;
        }
    }
}