<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Assurer;
use App\Models\Beneficiaire;
use App\Models\Contrat;
use App\Models\DeclarationSante;
use App\Models\Product;
use App\Models\ReseauProduct;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class LinkSouscriptionController extends Controller
{
    public function index()
    {

        $commercial = auth()->user()->membre;
        return view('productions.link.index', compact('commercial'));
    }

    public function create()
    {
       return view('productions.link.create');
    }

    public function checkAssure(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'matricule' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Le matricule est obligatoire.',
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            $contrat = Contrat::where('numerocompte', $request->matricule)->first();

            if($contrat->etape == 2){
                return response()->json([
                    'status' => false,
                    'message' => 'Le contrat a déjà été Mis a jour.',
                    'count' => 0,
                    'adherentData' => null,
                ]);
            }

            if(!$contrat){
                return response()->json([
                    'status' => false,
                    'message' => 'Contrat non trouvé.',
                    'count' => 0,
                    'adherentData' => null,
                ]);
            }else{
                $adherent = $contrat->adherent;

                return response()->json([
                    'status' => true,
                    'message' => 'Contrat trouver.',
                    'adherentData' => $adherent
                ]);
            }


        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'Erreur interne du serveur.',
                'error' => config('app.debug') ? $th->getMessage() : null,
            ], 500);
        }
    }
    public function checkAssureOld(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'matricule' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Le matricule est obligatoire.',
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            $contrat = Contrat::where('numerocompte', $request->matricule)->first();

            if(!$contrat){
                return response()->json([
                    'status' => false,
                    'message' => 'Contrat non trouvé.',
                    'count' => 0,
                    'assureData' => null,
                ]);
            }else{
                $adherent = $contrat->adherent;

                Log::info("adherent trouver");

                Log::info($adherent);

                Log::info("debut envoie otp");
                $OTP_API = config('services.otp_api');
                // dd($OTP_API);
                
                $sendOtp = Http::post(''.$OTP_API.'api/send-otp' , [
                    'telIndicatif' => "225",
                    'telephone' => $adherent->mobile,
                ]);
                $otpResponse = $sendOtp->json();

                if($otpResponse['status'] == false){
                    return response()->json([
                        'status' => false,
                        'message' => $otpResponse['message'],
                        'count' => 0,
                        'assureData' => null,
                    ]);
                }

                return response()->json([
                    'status' => true,
                    'message' => 'Contrat trouver.',
                    'count' => 1,
                    'assureData' => $adherent
                ]);
            }


        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'Erreur interne du serveur.',
                'error' => config('app.debug') ? $th->getMessage() : null,
            ], 500);
        }
    }

    public function edit($data)
    {
        try {
           $matricule = $data;
           $contrat = Contrat::where('numerocompte', $matricule)->where('refcontratsource', $matricule)->first();
           
        } catch (\Throwable $th) {
            throw $th;
            
            return redirect()->response([
                'status' => 'error',
                'message' => 'Contrat non trouver' . $th->getMessage(),
                'error' => config('app.debug') ? $th->getMessage() : null,
                'code' => 500
            ]);
        }

        return view('productions.link.edit', compact('contrat'));
    }


    public function update(Request $request, $id)
    {
        DB::beginTransaction();

        try {

            $contrat = Contrat::findOrFail($id);
            $data = $request->all();

            Log::info('📥 Données reçues pour la mise à jour du contrat ID: ' . $id, $data);


            // 🔹 Mise à jour du contrat
            $contrat->update([
                'details' => $request->observe ?? null,
                'etape' => 2,
                'transmisle' => now(),
            ]);

            // ✅ Tout est OK → validation
            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Mise à jour réussie',
                Log::info('Mise à jour du contrat réussie', ['contrat_id' => $id]),
            ]);

        } catch (\Throwable $th) {

            // ❌ rollback automatique
            DB::rollBack();

            Log::error('Erreur update contrat', [
                'message' => $th->getMessage(),
                'line' => $th->getLine(),
                'file' => $th->getFile(),
            ]);

            return response()->json([
                'status' => 'error',
                'message' => 'Erreur lors de la mise à jour',
                'error' => config('app.debug') ? $th->getMessage() : null,
            ], 500);
        }
    }

    public function success($id)
    {
        $contrat = Contrat::with('assures')->find($id);
        
        if (!$contrat) {
            abort(404);
        }
        
        return view('productions.link.success', compact('contrat'));
    }


}

