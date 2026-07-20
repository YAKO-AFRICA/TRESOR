<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Imports\AssuresImport;
use App\Imports\EnfantsImport;
use App\Models\Adherent;
use App\Models\Assurer;
use App\Models\Beneficiaire;
use App\Models\Contrat;
use auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;

class IntegrationController extends Controller
{
    public function index()
    {
        // Récupérer les données de session
        $assures = Session::get('integration_assures', []);
        $enfants = Session::get('integration_enfants', []);
        $rapport = Session::get('integration_rapport', [
            'total_assures' => 0,
            'valides' => 0,
            'erreurs' => [],
            'enfants_total' => 0,
            'enfants_valides' => 0,
            'enfants_erreurs' => []
        ]);

        return view('productions.integrations.index', compact('assures', 'enfants', 'rapport'));
    }

    public function upload(Request $request)
    {
        $request->validate([
            'file_assures' => 'required|mimes:xlsx,xls,csv|max:2048',
            'file_enfants' => 'nullable|mimes:xlsx,xls,csv|max:2048'
        ]);

        try {
            // Nettoyer les sessions précédentes
            Session::forget(['integration_assures', 'integration_enfants', 'integration_rapport']);

            // Importer les assurés
            $assuresImport = new AssuresImport();

            Log::info($request->file('file_assures'));
            
            Excel::import($assuresImport, $request->file('file_assures'));
            
            $assures = $assuresImport->getData();
            $assuresErreurs = $assuresImport->getErreurs();
            // Log::info('Assurés importés: ' . count($assures) . ', Erreurs: ' . count($assuresErreurs));

            // Importer les enfants si le fichier est fourni
            $enfants = [];
            $enfantsErreurs = [];
            if ($request->hasFile('file_enfants')) {
                $enfantsImport = new EnfantsImport();
                Excel::import($enfantsImport, $request->file('file_enfants'));
                $enfants = $enfantsImport->getData();
                $enfantsErreurs = $enfantsImport->getErreurs();
            }

            // Construire le rapport
            $rapport = [
                'total_assures' => count($assures) + count($assuresErreurs),
                'valides' => count($assures),
                'erreurs' => $assuresErreurs,
                'enfants_total' => count($enfants) + count($enfantsErreurs),
                'enfants_valides' => count($enfants),
                'enfants_erreurs' => $enfantsErreurs
            ];

            // Stocker en session
            Session::put('integration_assures', $assures);
            Session::put('integration_enfants', $enfants);
            Session::put('integration_rapport', $rapport);

            // Log::info('Fichiers chargés avec succès !' . ' Assurés: ' . count($assures) . ', Erreurs Assurés: ' . count($assuresErreurs) .
            //     ', Enfants: ' . count($enfants) . ', Erreurs Enfants: ' . count($enfantsErreurs));

            return redirect()->route('integrations.index')
                ->with('success', 'Fichiers chargés avec succès !');

        } catch (\Exception $e) {
            return redirect()->route('integrations.index')
                ->with('error', 'Erreur lors du chargement des fichiers : ' . $e->getMessage());
        }
    }

    public function valider(Request $request)
    {
        $assures = Session::get('integration_assures', []);
        $enfants = Session::get('integration_enfants', []);
        

        if (empty($assures)) {
            return redirect()->route('integrations.index')
                ->with('error', 'Aucune donnée à valider. Veuillez d\'abord charger les fichiers.');
        }

        try {
            // Vérifier les liaisons assurés-enfants
            $matriculesAssures = collect($assures)->pluck('matricule')->toArray();
            $enfantsOrphelins = collect($enfants)->filter(function($enfant) use ($matriculesAssures) {
                return !in_array($enfant['matricule'], $matriculesAssures);
            });

            if ($enfantsOrphelins->isNotEmpty()) {
                $message = 'Attention : ' . $enfantsOrphelins->count() . ' enfant(s) n\'ont pas de correspondance avec un assuré.';
                return redirect()->route('integrations.index')
                    ->with('warning', $message)
                    ->with('error_details', $enfantsOrphelins->map(function($e) {
                        return "Enfant {$e['prenoms']} {$e['nom']} (matricule: {$e['matricule']})";
                    })->toArray());
            }

            // Ici vous pouvez ajouter la logique d'enregistrement en base de données
            // DB::transaction(function() use ($assures, $enfants) {
            //     foreach($assures as $assure) {
            //         // Enregistrer l'assuré
            //         $assureModel = Assure::create($assure);
            //         // Enregistrer ses enfants
            //         $enfantsAssure = collect($enfants)->where('matricule', $assure['matricule']);
            //         foreach($enfantsAssure as $enfant) {
            //             $assureModel->enfants()->create($enfant);
            //         }
            //     }
            // });

            $this->prepareInsertData($assures, $enfants);

            // Nettoyer la session après validation
            Session::forget(['integration_assures', 'integration_enfants', 'integration_rapport']);

            return redirect()->route('integrations.index')
                ->with('success', 'Les données ont été validées avec succès !');

        } catch (\Exception $e) {
            return redirect()->route('integrations.index')
                ->with('error', 'Erreur lors de la validation : ' . $e->getMessage());
        }
    }

    public function annuler()
    {
        Session::forget(['integration_assures', 'integration_enfants', 'integration_rapport']);
        
        return redirect()->route('integrations.index')
            ->with('success', 'Les données chargées ont été annulées.');
    }

    private function prepareInsertData($assures, $enfants)
    {
        try {
            DB::transaction(function() use ($assures, $enfants) {
                // Récupérer les IDs max une seule fois pour optimiser
                $maxAdherentId = Adherent::max('id') ?? 0;
                $maxContratId = Contrat::max('id') ?? 0;
                $maxAssureId = Assurer::max('id') ?? 0;
                $maxBenefId = Beneficiaire::max('id') ?? 0;
                
                $key = now()->format('Ymd');
                $keyUniq = "LPREVO_" . $key . "_" . uniqid();
                
                // Grouper les enfants par matricule 
                $enfantsByMatricule = collect($enfants)->groupBy('matricule');
                
                foreach($assures as $index => $assure) {
                    // Incrémenter les IDs
                    $idAdherent = ++$maxAdherentId;
                    $idContrat = ++$maxContratId;
                    $idAssure = ++$maxAssureId;
                    
                    // Récupérer les enfants de cet assuré
                    $enfantsAssure = $enfantsByMatricule->get($assure['matricule'], collect())->values()->toArray();
                    
                    // Préparer les données de l'adhérent
                    $adherentData = $this->prepareAdherentData($assure, $keyUniq);
                    
                    // Créer l'adhérent
                    $adherent = Adherent::create($adherentData);
                    Log::info("Adhérent créé - ID: {$adherent->id}, Matricule: {$assure['matricule']}");
                    
                    // Préparer les données du contrat
                    $contratData = $this->prepareContratData($assure, $idAdherent, $keyUniq);
                    
                    // Créer le contrat
                    $contrat = Contrat::create($contratData);
                    Log::info("Contrat créé - ID: {$contrat->id}, Adhérent: {$idAdherent}");
                    
                    // Préparer les données de l'assuré
                    $assureData = $this->prepareAssureData($assure, $idAdherent, $idContrat, $keyUniq);
                    
                    // Créer l'assuré
                    $assurePrincipal = Assurer::create($assureData);
                    Log::info("Assuré créé - ID: {$assurePrincipal->id}, Contrat: {$idContrat}");
                    
                    // Créer les bénéficiaires (enfants)
                    if (!empty($enfantsAssure)) {
                        foreach($enfantsAssure as $enfant) {
                            $idBenef = ++$maxBenefId;
                            
                            $benefData = $this->prepareBeneficiaireData(
                                $enfant, 
                                $idBenef, 
                                $idAdherent, 
                                $idContrat, 
                                $keyUniq
                            );
                            
                            $beneficiaire = Beneficiaire::create($benefData);
                            Log::info("Bénéficiaire créé - ID: {$beneficiaire->id}, Enfant: {$enfant['nom']} {$enfant['prenoms']}");
                        }
                    }


                    $this->sendSms($assure);
                }

                Log::info("Transaction terminée avec succès - " . count($assures) . " assurés traités");
                
            }, 5); // Retry 5 fois en cas de deadlock
            
        } catch (\Throwable $th) {
            Log::error("Erreur lors de la transaction : " . $th->getMessage());
            Log::error($th->getTraceAsString());
            throw $th;
        }
    }

    /**
     * Préparer les données de l'adhérent
     */
    private function prepareAdherentData($assure, $keyUniq)
    {
        return [
            'civilite' => $assure['genre'] ?? null,
            'nom' => $assure['nom'] ?? '',
            'prenom' => $assure['prenoms'] ?? '',
            'datenaissance' => $this->formatDate($assure['date_naissance']),
            'lieunaissance' => $assure['lieu_naissance'] ?? null,
            'situationMatrimoniale' => $assure['situation_matrimoniale'] ?? null,
            'sexe' => $assure['genre'] ?? null,
            'numeropiece' => $assure['num_cni'] ?? $assure['num_nni'] ?? null,
            'naturepiece' => $assure['naturepiece'] ?? null,
            'lieuresidence' => $assure['lieu_residence'] ?? null,
            'profession' => $assure['fonction'] ?? null,
            'employeur' => $assure['employeur'] ?? null,
            'pays' => $assure['pays'] ?? null,
            'estmigre' => 0,
            'email' => $assure['email'] ?? null,
            'mobile' => $assure['numero_tel'] ?? null,
            'telephone' => $assure['num_what'] ?? null,
            'telephone1' => $assure['numero_tel'] ?? null,
            'codemembre' => 0,
            'saisieLe' => now(),
            'saisiepar' => auth()->user()->membre->idmembre ?? null,
            'refcontratsource' => $assure['matricule'] ?? null,
            'cleintegration' => $keyUniq,
        ];
    }

    /**
     * Préparer les données du contrat
     */
    private function prepareContratData($assure, $idAdherent, $keyUniq)
    {
        return [
            'dateeffet' => '2026-07-01 00:00:00',
            'modepaiement' => "SOCIETE",
            'organisme' => "DGTCP",
            'numerocompte' => $assure['matricule'] ?? null,
            'periodicite' => "A",
            'nomagent' => "TRESOR",
            'primepricipale' => 16900.00,
            'prime' => 16900.00,
            'fraisadhesion' => 0,
            'surprime' => 0,
            'capital' => 4000000.00,
            'etape' => 1,
            'saisiele' => now(),
            'saisiepar' => auth()->user()->membre->idmembre ?? "123456789",
            'duree' => "1",
            'codeadherent' => $idAdherent,
            'estMigre' => 0,
            'codeproduit' => "LPREVO",
            'libelleproduit' => "LOYALE PREVOYANCE",
            'personneressource' => $assure['nom_urgence'] ?? null,
            'contactpersonneressource' => $assure['num_urgence'] ?? null,
            'branche' => "DIRECTENTREPRISE",
            'partenaire' => "tresor",
            'cleintegration' => $keyUniq,
            'estpaye' => 0,
            'nomsouscipteur' => ($assure['nom'] ?? '') . ' ' . ($assure['prenoms'] ?? ''),
            'typesouscipteur' => "GROUPE",
            'refcontratsource' => $assure['matricule'] ?? null,
            'etat' => 1,
        ];
    }

    /**
     * Préparer les données de l'assuré
     */
    private function prepareAssureData($assure, $idAdherent, $idContrat, $keyUniq)
    {
        return [
            'civilite' => $assure['genre'] ?? null,
            'nom' => $assure['nom'] ?? '',
            'prenom' => $assure['prenoms'] ?? '',
            'filiation' => "LUIMM",
            'datenaissance' => $this->formatDate($assure['date_naissance']),
            'lieunaissance' => $assure['lieu_naissance'] ?? null,
            'codecontrat' => $idContrat,
            'codeadherent' => $idAdherent,
            'sexe' => $assure['genre'] ?? null,
            'numeropiece' => $assure['num_cni'] ?? $assure['num_nni'] ?? null,
            'naturepiece' => $assure['naturepiece'] ?? null,
            'lieuresidence' => $assure['lieu_residence'] ?? null,
            'profession' => $assure['fonction'] ?? null,
            'employeur' => $assure['employeur'] ?? null,
            'pays' => $assure['pays'] ?? null,
            'email' => $assure['email'] ?? null,
            'telephone' => $assure['numero_tel'] ?? null,
            'telephone1' => $assure['num_what'] ?? null,
            'mobile' => $assure['numero_tel'] ?? null,
            'codemembre' => 0,
            'mobile1' => $assure['num_what'] ?? null,
            'saisieLe' => now(),
            'saisiepar' => auth()->user()->membre->idmembre ?? null,
            'cleintegration' => $keyUniq,
            'refcontratsource' => $assure['matricule'] ?? null,
            'estmigre' => 0,
        ];
    }

    /**
     * Préparer les données du bénéficiaire
     */
    private function prepareBeneficiaireData($enfant, $idBenef, $idAdherent, $idContrat, $keyUniq)
    {

        Log::info("info sur les enfant recu : " . json_encode($enfant) . "" );
        return [
            'id' => $idBenef,
            'civilite' => $enfant['genre'] ?? null,
            'nom' => $enfant['nom'] ?? '',
            'prenom' => $enfant['prenoms'] ?? '',
            'datenaissance' => $this->formatDate($enfant['date_naissance']),
            'codecontrat' => $idContrat,
            'codeadherent' => $idAdherent,
            'filiation' => "ENFANT",
            'saisieLe' => now(),
            'saisiepar' => auth()->user()->membre->idmembre ?? null,
            'cleintegration' => $keyUniq,
            'refcontratsource' => $enfant['matricule'] ?? null,
            'sexe' => $enfant['genre'] ?? null,
            'numeropiece' => $enfant['num_piece'] ?? null,
            'naturepiece' => $enfant['nature_piece'] ?? null,
            'lieunaissance' => $enfant['lieu_naissance'] ?? null,
            'bp' => $enfant['niveau_etude'] ?? null,
        ];
    }

    /**
     * Formater une date
     */
    private function formatDate($date)
    {
        if (empty($date)) {
            return null;
        }
        
        try {
            if ($date instanceof \DateTime) {
                return $date->format('Y-m-d');
            }
            
            if (is_string($date)) {
                return Carbon::parse($date)->format('Y-m-d');
            }
            
            return null;
        } catch (\Exception $e) {
            Log::warning("Erreur de formatage de date : " . $e->getMessage());
            return null;
        }
    }

    // private function sendSms($assure)
    // {
    //     try {
    //         $phone = $assure['numero_tel'];
    //         $matricule = $assure['matricule'];
    //         $SOUSCRIPTION_URL = route('link.create');
    //         $message = "Bonjour " . $assure['nom'] . " " . $assure['prenoms'] . ", Veuillez cliquer ce lien pour finaliser votre souscription : " . $SOUSCRIPTION_URL;
    //         $sending = Http::post('https://apimain.yakoafricassur.com/api/send-sms', [
    //             'phone' => $phone,
    //             'message' => $message
    //         ]);
    //     } catch (\Exception $e) {
    //         Log::warning("Erreur d'envoi de SMS : " . $e->getMessage());
    //     }
    // }

    private function sendSms($assure)
    {
        try {

            $phone = preg_replace('/\s+/', '', $assure['numero_tel']); // retire les espaces
            $matricule = $assure['matricule'];

            $SOUSCRIPTION_URL = route('link.create', ['matricule' => $matricule]);

            $message = "Bonjour {$assure['nom']} {$assure['prenoms']}, Veuillez cliquer sur ce lien pour finaliser votre souscription : {$SOUSCRIPTION_URL}";

            /**
             * MTN : 05XXXXXXXX
             * Orange : 07XXXXXXXX
             */
            // if (preg_match('/^0?5\d{8}$/', $phone)) {
            if (preg_match('/^0?[57]\d{8}$/', $phone)) {

                // Conversion au format international
                $phone = '+225' . substr($phone, -10);

                $response = Http::withHeaders([
                    'Authorization' => 'Bearer ' . env('SAYELESEND_API_KEY'),
                    'Content-Type'  => 'application/json',
                ])->post('https://api.sayelesend.com/api/v1/sms/send', [
                    'to'      => $phone,
                    'message' => $message,
                    'from'    => 'YAKO AFRICA',
                ]);

            } else {

                // autres fournisseurs, Moov...
                $response = Http::post('https://apimain.yakoafricassur.com/api/send-sms', [
                    'phone'   => $phone,
                    'message' => $message,
                ]);
            }

            Log::info('Réponse SMS', [
                'telephone' => $phone,
                'status'    => $response->status(),
                'body'      => $response->body(),
            ]);

            if (!$response->successful()) {
                Log::warning('Echec envoi SMS', [
                    'telephone' => $phone,
                    'response'  => $response->body(),
                ]);
            }

        } catch (\Exception $e) {

            Log::error("Erreur d'envoi de SMS : " . $e->getMessage(), [
                'assure' => $assure
            ]);

        }
    }


}