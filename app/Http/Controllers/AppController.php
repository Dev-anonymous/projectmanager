<?php

namespace App\Http\Controllers;

use App\Mail\RecoveryMail;
use App\Models\Depot;
use App\Models\Invoice;
use App\Models\Pay;
use App\Models\Pending;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;


class AppController extends Controller
{
    function login()
    {
        $data['email'] = request('email');
        $data['password'] = request('pass');

        if (Auth::attempt($data, request()->has('remember'))) {
            $user = auth()->user();

            return [
                'success' => true,
                'message' => "Connexion reussie.",
                'token' => $user->createToken('token')->plainTextToken
            ];
        }
        return [
            'success' => false,
            'message' => "Echec de connexion."
        ];
    }

    function logout()
    {
        if (Auth::check()) {
            Auth::logout();
        }
        return [];
    }

    function cpa()
    {
        $validator = Validator::make(request()->all(), [
            'montant' => 'required',
            'users_id' => 'required|exists:users,id',
            'devise' => 'required|in:CDF,USD',
        ]);

        if ($validator->fails()) {
            return [
                'message' => implode(" ", $validator->errors()->all())
            ];
        }
        $data  = $validator->validated();

        $montant = str_replace([' ', ','], ['', '.'],  request('montant'));
        $users_id = request('users_id');
        $devise = request('devise');

        if ($montant <= 0) {
            return [
                'message' => "Montant invalide"
            ];
        }

        $chauffeur = User::find($users_id);
        $profil = $chauffeur->profils()->first();
        abort_if($chauffeur->user_role != 'driver', 403);

        $mcdf = change($montant, $devise, 'CDF');
        $musd = change($montant, $devise, 'USD');

        $agent = auth()->user();

        DB::beginTransaction();
        Depot::create([
            'profil_id' => $profil->id,
            'users_id' => $agent->id,
            'agentname' => $agent->name,
            'type' => 'cash',
            'montant_cdf' => $mcdf,
            'montant_usd' => $musd,
            'commission' => COMMISSION,
            'devise_depot' => $devise,
            'ref' => $ref = transid($chauffeur),
            'date' => nnow(),
        ]);
        $dev = strtolower($devise);
        $profil->increment("solde_$dev", $montantrecu = commission($montant));

        $montantrecu = v($montantrecu, $devise);

        $commission = 100 * COMMISSION;
        $montant = v($montant, $devise);

        $phone = $profil->user->phone;

        $txt = "Depot (CASH) de $montant (-$commission%)\nMontant recu : $montantrecu\nAgent : $agent->name\nTransID : $ref";
        if ('yes' == getconfig('sms')) {
            Pending::create(['to' => $phone, 'text' => $txt, 'retry' => 0]);
        }

        DB::commit();

        return [
            'success' => true,
            'message' => "Transaction enregistrée.",
            'ref' => $ref
        ];
    }

    function fpi()
    {
        $validator = Validator::make(request()->all(), [
            'montant' => 'required',
            'users_id' => 'required|exists:users,id',
            'devise' => 'required|in:CDF,USD',
            'phone' => 'required|string|min:10|max:10',
        ], ['phone.required' => 'Saisissez le numéro Mobile Money']);

        if ($validator->fails()) {
            return [
                'message' => implode(" ", $validator->errors()->all())
            ];
        }
        $data  = $validator->validated();

        $amount = str_replace([' ', ','], ['', '.'],  request('montant'));

        if ($amount <= 0) {
            return [
                'message' =>   "Le montant de paiement $amount n'est pas valide."
            ];
        }

        $devise = request('devise');
        if ($devise == 'CDF' && $amount < 500) {
            return [
                'message' => 'Le montant minimum de paiement est de 500 FC'
            ];
        }

        $phone = request('phone');

        if (!isvalidenumber($phone)) {
            return [
                'message' => "Numéro de téléphone non valide"
            ];
        }

        $chauffeur = User::find(request('users_id'));
        $profil = $chauffeur->profils()->first();
        abort_if($chauffeur->user_role != 'driver', 403);
        $ref = transid($chauffeur);
        $mcdf = change($amount, $devise, 'CDF');
        $musd = change($amount, $devise, 'USD');
        $agent = auth()->user();

        $payment_method = 'mobile_money';
        $phone_number = request('phone');

        $data = compact('payment_method', 'phone_number', 'devise', 'amount');
        $insertdata = [
            'profil_id' => $profil->id,
            'users_id' => $agent->id,
            'agentname' => $agent->name,
            'type' => $payment_method,
            'montant_cdf' => $mcdf,
            'montant_usd' => $musd,
            'commission' => COMMISSION,
            'devise_depot' => $devise,
            'ref' => $ref,
            'date' => nnow(),
        ];
        $data['insertdata'] = $insertdata;

        $fp = Pay::create([
            'data' => json_encode($data),
            'ref' => $ref,
            'failed' => 0,
            'saved' => 0,
            'payment_method' => $payment_method,
            'date' => nnow(),
        ]);

        $pn = "243" . ((int) $phone);
        $rep = (object) ipf($devise, $amount, $pn, $ref);

        if ($rep->status) {
            $data['apiresponse'] = $rep->data;
            $fp->update(['data' => json_encode($data)]);
        }
        return [
            'success' => $rep->status,
            'message' => $rep->message,
            'ref' => $ref
        ];
    }
    function fpc()
    {
        $ref = request('ref');
        $pay = Pay::where(compact('ref'))->first();
        if ($pay) {
            $ok =  false;
            $saved = $pay->saved;

            $data = @json_decode($pay->data);
            $orderNumber = @$data->apiresponse->orderNumber;
            if ($orderNumber) {
                $t = transaction_was_success($orderNumber);
                if ($t === true) {
                    savedata($pay);
                    $ok = true;
                } else {
                    if ($t === false) {
                        $pay->update(['saved' => 0, 'failed' => 1]);
                    }
                }
            }

            if ($ok || $saved === 1 || @$pay->saved === 1) {
                return response()->json([
                    'success' => true,
                    'message' => "Paiement effectuée avec succès.",
                    'transaction' => ['status' => 'success']
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => "Aucune transaction trouvée.",
                    'transaction' => ['status' => @$t === false ? 'failed' : 'pending']
                ]);
            }
        }
    }

    function sti()
    {
        $validator = Validator::make(request()->all(), [
            'montant' => 'required',
            'users_id' => 'required|exists:users,id',
            'devise' => 'required|in:CDF,USD',
            'phone' => 'required|string|min:10|max:10',
        ], ['phone.required' => 'Saisissez le numéro Illico Cash']);

        if ($validator->fails()) {
            return [
                'message' => implode(" ", $validator->errors()->all())
            ];
        }
        $data  = $validator->validated();

        $montant = str_replace([' ', ','], ['', '.'],  request('montant'));

        if ($montant <= 0) {
            return [
                'message' =>   "Le montant de paiement $montant n'est pas valide."
            ];
        }

        $phone = request('phone');
        $devise = request('devise');

        if (!isvalidenumber($phone)) {
            return [
                'message' => "Numéro de téléphone non valide"
            ];
        }

        $chauffeur = User::find(request('users_id'));
        $profil = $chauffeur->profils()->first();
        abort_if($chauffeur->user_role != 'driver', 403);

        $ref = transid($chauffeur);

        $mcdf = change($montant, $devise, 'CDF');
        $musd = change($montant, $devise, 'USD');

        $agent = auth()->user();

        $data = compact('phone', 'devise');
        $insertdata = [
            'profil_id' => $profil->id,
            'users_id' => $agent->id,
            'agentname' => $agent->name,
            'type' => 'illico_cash',
            'montant_cdf' => $mcdf,
            'montant_usd' => $musd,
            'commission' => COMMISSION,
            'devise_depot' => $devise,
            'ref' => $ref = transid($chauffeur),
            'date' => nnow(),
        ];
        $data['insertdata'] = $insertdata;

        try {
            $rep = iinit($phone, $montant, $devise, $ref);
        } catch (\Throwable $th) {
            throw $th;
        }

        $resp['success'] = $ok = @$rep->respcode === '00';
        if (@$rep->respcode != '00') {
            $resp['message'] = "Echec de transaction : " . @$rep->respcodedesc;
        } else {
            $resp['message'] = "Transaction initialisée. veuillez saisir l'OTP.";
        }
        $resp['ref'] = $ref;
        if ($ok) {
            $data['apiresponse'] = $rep;
            Pay::create([
                'data' => json_encode($data),
                'ref' => $ref,
                'failed' => 0,
                'saved' => 0,
                'payment_method' => 'illico_cash',
            ]);
        }

        return $resp;
    }

    function cmi()
    {
        $ref = request('ref');
        $otp = request('otp');

        $pay = Pay::where(compact('ref'))->first();
        if ($pay) {
            $user = @json_decode($pay->user);
            $referencenumber = @$user->apiresponse->referencenumber;
            try {
                $rep = cmi($referencenumber, $otp);
            } catch (\Throwable $th) {
                //throw $th;
            }

            $resp['success'] = $ok = @$rep->respcode === '00';

            if ($ok) {
                savedata($pay);
                $resp['message'] = "Paiement approuvé.";
            } else {
                $resp['message'] = "Echec de paiement, l'OTP saisi est invalide.";
            }
            return $resp;
        }
    }

    function smc()
    {
        $validator = Validator::make(request()->all(), [
            'montant' => 'required',
            'card_number' => 'required|min:16',
            'expiry_date' => 'required',
            'cvv' => 'required',
            'users_id' => 'required|exists:users,id',
            'devise' => 'required|in:CDF,USD',
        ]);

        if ($validator->fails()) {
            return [
                'message' => implode(" ", $validator->errors()->all())
            ];
        }
        $data  = $validator->validated();

        $montant = str_replace([' ', ','], ['', '.'],  request('montant'));

        if ($montant <= 0) {
            return [
                'message' =>   "Le montant de paiement $montant n'est pas valide."
            ];
        }

        $devise = request('devise');
        $chauffeur = User::find(request('users_id'));
        $profil = $chauffeur->profils()->first();
        abort_if($chauffeur->user_role != 'driver', 403);
        $ref = transid($chauffeur);
        $mcdf = change($montant, $devise, 'CDF');
        $musd = change($montant, $devise, 'USD');
        $agent = auth()->user();

        $payment_method = 'carte_bancaire';

        $data1 = compact('payment_method', 'devise', 'montant');
        $insertdata = [
            'profil_id' => $profil->id,
            'users_id' => $agent->id,
            'agentname' => $agent->name,
            'type' => $payment_method,
            'montant_cdf' => $mcdf,
            'montant_usd' => $musd,
            'commission' => COMMISSION,
            'devise_depot' => $devise,
            'ref' => $ref,
            'date' => nnow(),
        ];
        $data1['insertdata'] = $insertdata;

        $ed = request('expiry_date');
        $ed = explode('/', explode(' ', $ed)[1]);
        if (!is_numeric($ed[0]) or !is_numeric($ed[1])) {
            return [
                'message' =>   "La date d'expiration de la carte bancaire est invalide."
            ];
        }

        $data = new \stdClass();
        $data->montant = round($montant, 2);
        $data->devise = strtoupper($devise);
        $data->numcarte = request('card_number');
        $data->mois_exp = $ed[0];
        $data->annee_exp = $ed[1];
        $data->cvv = request('cvv');
        $data->description = "Paiement";
        $data->data = $data1;
        $data->ref = $ref;

        $res = _3ds($data);

        // 5123459999998221
        // 01-30-123

        if ($res->status == true) {
            if (@$res->payNow == true) {
                $r = _payWithNo3ds($res->pay_url, $res->pay_body, $res->headers);
                if ($r->status == true) {
                    $data1['api'] = $res;
                    $pd = Pay::create([
                        'data' => json_encode($data1),
                        'ref' => $ref,
                        'failed' => 0,
                        'saved' => 1,
                        'payment_method' => $payment_method,
                        'date' => nnow(),
                    ]);
                    savedata($pd);
                    return [
                        'success' => true,
                        'message' => $r->message
                    ];
                } else {
                    return [
                        'success' => false,
                        'message' => $r->message
                    ];
                }
            } else {
                $data1['api'] = $res;
                Pay::create([
                    'data' => json_encode($data1),
                    'ref' => $ref,
                    'failed' => 0,
                    'saved' => 0,
                    'payment_method' => $payment_method,
                    'date' => nnow(),
                ]);
                return [
                    'success' => true,
                    'message' => $res->message,
                    'pay_url' => $res->pay_url,
                ];
            }
        } else {
            return [
                'success' => false,
                'message' => $res->message
            ];
        }
    }
}
