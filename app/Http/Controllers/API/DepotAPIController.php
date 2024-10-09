<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Depot;
use Illuminate\Http\Request;

class DepotAPIController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_role = auth()->user()->user_role;

        $date = request('date');
        $dfrom = $dto = date('Y-m-d');
        $date = explode(' to ', $date);
        if (2 == count($date)) {
            $dfrom = $date[0];
            $dto = $date[1];
        }

        $cash = Depot::selectRaw('sum(montant_cdf) as montant_cdf, sum(montant_usd) as montant_usd, devise_depot as devise')->whereDate('date', '>=', $dfrom)->whereDate('date', '<=', $dto)->where('type', 'cash')->groupBy('devise_depot');
        $illico_cash = Depot::selectRaw('sum(montant_cdf) as montant_cdf, sum(montant_usd) as montant_usd, devise_depot as devise')->whereDate('date', '>=', $dfrom)->whereDate('date', '<=', $dto)->where('type', 'illico_cash')->groupBy('devise_depot');
        $mobile_money = Depot::selectRaw('sum(montant_cdf) as montant_cdf, sum(montant_usd) as montant_usd, devise_depot as devise')->whereDate('date', '>=', $dfrom)->whereDate('date', '<=', $dto)->where('type', 'mobile_money')->groupBy('devise_depot');
        $carte_bancaire = Depot::selectRaw('sum(montant_cdf) as montant_cdf, sum(montant_usd) as montant_usd, devise_depot as devise')->whereDate('date', '>=', $dfrom)->whereDate('date', '<=', $dto)->where('type', 'carte_bancaire')->groupBy('devise_depot');

        if ('admin' == $user_role) {
            //
        } else if ('driver' == $user_role) {
            $profil = auth()->user()->profils()->first();
            $cash = $cash->where('profil_id', $profil->id);
            $illico_cash = $illico_cash->where('profil_id', $profil->id);
            $mobile_money = $mobile_money->where('profil_id', $profil->id);
            $carte_bancaire = $carte_bancaire->where('profil_id', $profil->id);
        } else if ('agent' == $user_role) {
            //
        } else {
            abort(403);
        }

        $cash = $cash->get();
        $illico_cash = $illico_cash->get();
        $mobile_money = $mobile_money->get();
        $carte_bancaire = $carte_bancaire->get();

        $t = [];
        foreach ($cash as $el) {
            if ($el->devise == 'CDF') {
                $t[] = v($el->montant_cdf, 'CDF');
            } elseif ($el->devise == 'USD') {
                $t[] = v($el->montant_usd, 'USD');
            }
        }
        $cash = $t;

        $t = [];
        foreach ($illico_cash as $el) {
            if ($el->devise == 'CDF') {
                $t[] = v($el->montant_cdf, 'CDF');
            } elseif ($el->devise == 'USD') {
                $t[] = v($el->montant_usd, 'USD');
            }
        }
        $illico_cash = $t;

        $t = [];
        foreach ($mobile_money as $el) {
            if ($el->devise == 'CDF') {
                $t[] = v($el->montant_cdf, 'CDF');
            } elseif ($el->devise == 'USD') {
                $t[] = v($el->montant_usd, 'USD');
            }
        }
        $mobile_money = $t;

        $t = [];
        foreach ($carte_bancaire as $el) {
            if ($el->devise == 'CDF') {
                $t[] = v($el->montant_cdf, 'CDF');
            } elseif ($el->devise == 'USD') {
                $t[] = v($el->montant_usd, 'USD');
            }
        }
        $carte_bancaire = $t;

        $t = Depot::whereDate('date', '>=', $dfrom)->whereDate('date', '<=', $dto)->orderBy('id', 'DESC');
        if ('admin' == $user_role) {
            //
        } else if ('driver' == $user_role) {
            $profil = auth()->user()->profils()->first();
            $t = $t->where('profil_id', $profil->id);
        } else if ('agent' == $user_role) {
        } else {
            abort(403);
        }


        $t = $t->get();
        $data = [];
        foreach ($t  as $el) {
            $u = (object) [];
            $trans = (object) [];
            $o = (object) [];

            $u->name = $el->profil->user->name;
            $u->phone = $el->profil->user->phone;
            $u->email = $el->profil->user->email;
            $u->code = $el->profil->user->code;

            $img = $el->profil->user->image;
            if ($img) {
                $img =   asset('storage/' . $img);
            } else {
                $img =   asset('/assets/images/faces/9.jpg');
            }
            $u->image = $img;

            $o->user = $u;

            $trans->type = strtoupper($el->type);
            $trans->commission = v((float) $el->commission * 100);
            if ('CDF' == $el->devise_depot) {
                $trans->montant = v($el->montant_cdf, 'CDF');
                $trans->montantrecu = v($el->montant_cdf - ((float)$el->commission * $el->montant_cdf), 'CDF');
            } elseif ('USD' == $el->devise_depot) {
                $trans->montant = v($el->montant_usd, 'USD');
                $trans->montantrecu = v($el->montant_usd - ((float)$el->commission * $el->montant_usd), 'USD');
            } else {
                die('dev');
            }
            $trans->date = $el->date->format('d-m-Y H:i:s');
            $trans->agent = $el->agentname;

            $o->trans = $trans;
            $data[] = $o;
        }

        $tab['trans']  = $data;

        if ('admin' == $user_role) {
            $tab['cash']  = $cash;
            $tab['illico_cash']  = $illico_cash;
            $tab['carte_bancaire']  = $carte_bancaire;
            $tab['mobile_money']  = $mobile_money;
        }

        if ('driver' == $user_role) {
            $profil = auth()->user()->profils()->first();
            $tab['solde_usd']  = v($profil->solde_usd, 'USD');
            $tab['solde_cdf']  = v($profil->solde_cdf, 'CDF');
        }

        return [
            'success' => true,
            'data' => $tab
        ];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Depot  $depot
     * @return \Illuminate\Http\Response
     */
    public function show(Depot $depot)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Depot  $depot
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Depot $depot)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Depot  $depot
     * @return \Illuminate\Http\Response
     */
    public function destroy(Depot $depot)
    {
        //
    }
}
