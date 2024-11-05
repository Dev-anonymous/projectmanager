<?php

namespace App\Http\Controllers;

use App\Mail\RecoveryMail;
use App\Models\Depot;
use App\Models\Invoice;
use App\Models\Pay;
use App\Models\Pending;
use App\Models\Product;
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


    function fpi()
    {
        $validator = Validator::make(request()->all(), [
            'phone' => 'required|string|min:10|max:10',
        ], ['phone.required' => 'Saisissez le numéro Mobile Money']);

        if ($validator->fails()) {
            return [
                'message' => implode(" ", $validator->errors()->all())
            ];
        }
        $phone = request('phone');
        if (!isvalidenumber($phone)) {
            return [
                'message' => "Numéro de téléphone non valide"
            ];
        }
        $data  = $validator->validated();

        $amount = 0;
        $articles = [];
        $error = [];
        foreach (auth()->user()->carts()->get() as $el) {
            $amount += $el->qty * $el->product->price;
            $articles[] = (object) [
                'id' => $el->product->id,
                'name' => $el->product->name,
                'price' => $el->product->price,
                'qty' => $el->qty,
                'total' => v($el->qty * $el->product->price, 'CDF'),
            ];
            $prod = Product::where('id', $el->product_id)->first();
            if ($el->qty > $prod->stock) {
                $error[] = "$prod->stock \"$prod->name\" en stock<br/>";
            }
        }

        if (count($error)) {
            $m = "Il ne reste que : <br/>" . implode(' ', $error);
            $m .= "Veuillez modifier la quantité dans votre panier.";
            return [
                'message' => $m
            ];
        }

        $devise = 'CDF';

        if ($devise == 'CDF' && $amount < 500) {
            return [
                'message' => 'Le montant minimum de paiement est de 500 FC'
            ];
        }
        abort_if(!in_array(auth()->user()->user_role, ['user', 'student']), 403);

        $pdata = compact('phone', 'devise', 'amount');

        $myref = uniqid('TRANS.', true);

        $insertdata = [
            'users_id' => auth()->user()->id,
            'articles' => json_encode($articles),
            'total_cdf' => $amount,
            'ref' => $myref,
            'date' => nnow(),
        ];
        $pdata['insertdata'] = $insertdata;

        $fp = Pay::create([
            'data' => json_encode($pdata),
            'myref' => $myref,
            'failed' => 0,
            'saved' => 0,
            'date' => nnow(),
        ]);

        $pn = "243" . ((int) $phone);
        $rep = gopay_init_payment($amount, $devise, $pn, $myref);

        if ($rep->success) {
            $pdata['apiresponse'] = $rep->data;
            $fp->update(['data' => json_encode($pdata), 'ref' => $rep->data->ref]);
        }
        return [
            'success' => $rep->success,
            'message' => $rep->message,
            'myref' => $myref
        ];
    }
    function fpc()
    {
        $myref = request()->myref;
        $ok =  false;
        $saved = 0;
        $trans = Pay::where(['myref' => $myref])->lockForUpdate()->first();

        if (!$trans) {
            return response([
                'success' => false,
                'message' => "Invalid ref"
            ]);
        };

        $t = transaction_status($myref);
        $status =   @$t->status;

        if ($status === 'success') {
            $saved = @Pay::where(['myref' => $myref])->first()->saved;
            if ($saved !== 1) {
                saveData($trans);
                $ok =  true;
                $trans->update(['failed' => 0]);
            }
        } else if ($status === 'failed') {
            $trans->update(['failed' => 1]);
        }

        if ($ok || $saved === 1 || @$trans->saved === 1) {
            return response([
                'success' => true,
                'message' => 'Votre paiement est effectué avec succès.',
                'transaction' => $t
            ]);
        } else {
            $m = "Aucun paiement trouvé.";
            return response([
                'success' => false,
                'message' => $m,
                'transaction' => $t
            ]);
        }
    }

    function newu()
    {
        $rules =  [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'phone' => 'required|max:10,min:10',
        ];

        $validator = Validator::make(request()->all(), $rules);

        if ($validator->fails()) {
            return [
                'message' => implode(" ", $validator->errors()->all())
            ];
        }

        $phone = request('phone');
        if (!isvalidenumber($phone)) {
            return [
                'message' => "Numéro de téléphone non valide"
            ];
        }
        $data  = $validator->validated();

        $data['password'] = Hash::make($data['password']);
        $data['name'] = ucfirst($data['name']);
        $data['user_role'] =  'user';
        $user = User::create($data);
        Auth::login($user, true);

        return [
            'success' => true,
            'message' => 'Votre compte a été créé. Bienvenue.',
            'token' => $user->createToken('token')->plainTextToken
        ];
    }
}
