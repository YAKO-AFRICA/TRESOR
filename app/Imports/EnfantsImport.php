<?php

namespace App\Imports;

use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToArray;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Validators\Failure;

class EnfantsImport implements ToArray, WithHeadingRow, WithValidation, SkipsOnFailure
{
    private $data = [];
    private $erreurs = [];
    private $rowIndex = 0;

    public function array(array $array)
    {
        Log::info('Début de l\'importation des enfants - Nombre de lignes: ' . count($array));
        
        foreach ($array as $row) {
            $this->rowIndex++;

            Log::info("Traitement de la ligne " . ($this->rowIndex + 1) . ": " . json_encode($row));

            // Vérifier si la ligne est vide
            $hasData = false;
            foreach ($row as $value) {
                if (!empty($value)) {
                    $hasData = true;
                    break;
                }
            }
            
            if (!$hasData) {
                Log::info("Ligne " . ($this->rowIndex + 1) . " vide, ignorée");
                continue;
            }
            
            // Vérifier les champs obligatoires
            if (empty($row['matricule']) || empty($row['nom']) || empty($row['prenom'])) {
                $this->erreurs[] = [
                    'ligne' => $this->rowIndex + 1,
                    'message' => 'Matricule, nom et prénoms sont obligatoires',
                    'data' => $row
                ];
                continue;
            }

            // Nettoyer et formater les données
            $enfant = [
                'matricule' => trim($row['matricule'] ?? ''),
                'genre' => isset($row['genre']) ? strtoupper(trim($row['genre'])) : null,
                'nom' => trim($row['nom'] ?? ''),
                'prenoms' => trim($row['prenom'] ?? ''),
                'date_naissance' => $this->formatDate($row['date_naissance'] ?? null),
                'niveau_etude' => trim($row['niveau_etude'] ?? '')
            ];

            // Validation des dates
            if ($enfant['date_naissance'] === null && !empty($row['date_naissance'])) {
                $this->erreurs[] = [
                    'ligne' => $this->rowIndex + 1,
                    'message' => 'Format de date de naissance invalide: ' . $row['date_naissance'],
                    'data' => $row
                ];
                continue;
            }

            $this->data[] = $enfant;
        }
        
        Log::info('Enfants valides: ' . count($this->data) . ', Erreurs: ' . count($this->erreurs));
    }

    public function rules(): array
    {
        return [
            'matricule' => 'required',
            'nom' => 'required',
            'prenom' => 'required',
        ];
    }

    /**
     * ✅ Messages de validation personnalisés pour des erreurs explicites
     */
    public function customValidationMessages(): array
    {
        return [
            'matricule.required' => 'Le matricule est obligatoire',
            'nom.required' => 'Le nom est obligatoire',
            'prenom.required' => 'Le prénom est obligatoire',
        ];
    }

    public function onFailure(Failure ...$failures)
    {
        foreach ($failures as $failure) {
            // Récupérer le message personnalisé ou le message par défaut
            $message = $failure->errors()[0] ?? 'Erreur de validation';
            
            $this->erreurs[] = [
                'ligne' => $failure->row(),
                'message' => $message, // Maintenant message explicite
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
            $date = trim($date);
            
            // Gérer le format JJ/MM/AAAA
            if (strpos($date, '/') !== false) {
                $parts = explode('/', $date);
                if (count($parts) === 3) {
                    if (strlen($parts[0]) == 2 && strlen($parts[1]) == 2 && strlen($parts[2]) == 4) {
                        return $parts[2] . '-' . str_pad($parts[1], 2, '0', STR_PAD_LEFT) . '-' . str_pad($parts[0], 2, '0', STR_PAD_LEFT);
                    }
                }
            }
            
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