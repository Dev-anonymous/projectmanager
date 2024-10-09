<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Depot;
use App\Models\Profil;
use App\Models\User;
use Illuminate\Http\Request;

class DashAPIController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = auth()->user();

        if ('admin' == $user->user_role) {
            $nbchauffeurs  = User::where('user_role', 'driver')->count();
            $nbagents  = User::where('user_role', 'agent')->count();
            $nbadmins  = User::where('user_role', 'admin')->count();

            $topdrivers  = Profil::orderBy('solde_usd', 'desc')->orderBy('solde_cdf', 'desc')->limit(10)->get();
            $t = [];

            foreach ($topdrivers as $el) {
                $o = (object)[];

                $img = $el->user->image;
                if ($img) {
                    $img =   asset('storage/' . $img);
                } else {
                    $img =   asset('/assets/images/faces/9.jpg');
                }
                $o->image = $img;
                $o->name = $el->user->name;
                $o->email = $el->user->email;
                $o->phone = $el->user->phone;
                $o->solde_cdf = v($el->solde_cdf, 'CDF');
                $o->solde_usd = v($el->solde_usd, 'USD');
                $t[] = $o;
            }
            $topdrivers = $t;
        }

        $recenttrans = Depot::orderBy('id', 'desc')->limit(10);

        if ('admin' == $user->user_role) {
            //
        } else if ('agent' == $user->user_role) {
            $recenttrans = $recenttrans->where('users_id', $user->id);
        } elseif ('driver' == $user->user_role) {
            $profil = $user->profils()->first();
            $recenttrans = $recenttrans->where('profil_id', $profil->id);
        } else {
            abort(403);
        }
        $recenttrans = $recenttrans->get();

        $t = [];
        foreach ($recenttrans as $el) {
            $u = (object) [];
            $trans = (object) [];
            $o = (object) [];

            $u->name = $el->profil->user->name;
            $u->phone = $el->profil->user->phone;
            $u->email = $el->profil->user->email;

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

            $o->trans = $trans;
            $t[] = $o;
        }
        $recenttrans = $t;

        if ('admin' == $user->user_role) {
            $cash = Depot::selectRaw('sum(montant_cdf) as montant_cdf, sum(montant_usd) as montant_usd, devise_depot as devise')->whereMonth('date', date('m'))->where('type', 'cash')->groupBy('devise_depot')->get();
            $illico_cash = Depot::selectRaw('sum(montant_cdf) as montant_cdf, sum(montant_usd) as montant_usd, devise_depot as devise')->whereMonth('date', date('m'))->where('type', 'illico_cash')->groupBy('devise_depot')->get();
            $mobile_money = Depot::selectRaw('sum(montant_cdf) as montant_cdf, sum(montant_usd) as montant_usd, devise_depot as devise')->whereMonth('date', date('m'))->where('type', 'mobile_money')->groupBy('devise_depot')->get();
            $carte_bancaire = Depot::selectRaw('sum(montant_cdf) as montant_cdf, sum(montant_usd) as montant_usd, devise_depot as devise')->whereMonth('date', date('m'))->where('type', 'carte_bancaire')->groupBy('devise_depot')->get();

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
        }

        $lab = ['Jan', 'Fev', 'Mar', 'Avr', 'Mai', 'Jui', 'Juil', 'Aou', 'Sep', 'Oct', 'Nov', 'Dec'];

        $cashtab = [];
        $illicotab = [];
        $mobiletab = [];
        $cartetab = [];
        foreach (range(1, 12) as $k => $m) {
            $cash2 = Depot::selectRaw('sum(montant_usd) as montant_usd')->whereMonth('date', $m)->where('type', 'cash');
            $illico_cash2 = Depot::selectRaw('sum(montant_usd) as montant_usd')->whereMonth('date', $m)->where('type', 'illico_cash');
            $mobile_money2 = Depot::selectRaw('sum(montant_usd) as montant_usd')->whereMonth('date', $m)->where('type', 'mobile_money');
            $carte_bancaire2 = Depot::selectRaw('sum(montant_usd) as montant_usd')->whereMonth('date', $m)->where('type', 'carte_bancaire');

            if ('admin' == $user->user_role) {
                //
            } elseif ('driver' == $user->user_role) {
                $profil = $user->profils()->first();
                $cash2 = $cash2->where('profil_id', $profil->id);
                $illico_cash2 = $illico_cash2->where('profil_id', $profil->id);
                $mobile_money2 = $mobile_money2->where('profil_id', $profil->id);
                $carte_bancaire2 = $carte_bancaire2->where('profil_id', $profil->id);
            } else if ('agent' == $user->user_role) {
                $cash2 = $cash2->where('users_id', $user->id);
                $illico_cash2 = $illico_cash2->where('users_id', $user->id);
                $mobile_money2 = $mobile_money2->where('users_id', $user->id);
                $carte_bancaire2 = $carte_bancaire2->where('users_id', $user->id);
            } else {
                abort(403);
            }

            $cash2 = $cash2->get();
            $illico_cash2 = $illico_cash2->get();
            $mobile_money2 = $mobile_money2->get();
            $carte_bancaire2 = $carte_bancaire2->get();

            $t = (float) $cash2[0]->montant_usd;
            $cashtab[] = (object) ['x' => $lab[$k], 'y' => $t];

            $t = (float) $illico_cash2[0]->montant_usd;
            $illicotab[] = (object) ['x' => $lab[$k], 'y' => $t];

            $t = (float) $mobile_money2[0]->montant_usd;
            $mobiletab[] = (object) ['x' => $lab[$k], 'y' => $t];

            $t = (float) $carte_bancaire2[0]->montant_usd;
            $cartetab[] = (object) ['x' => $lab[$k], 'y' => $t];
        }

        $series[] = (object) [
            "type" => 'line',
            'name' => 'Carte_bancaire',
            'data' => $cartetab
        ];
        $series[] = (object) [
            "type" => 'line',
            'name' => 'Mobile_money',
            'data' => $mobiletab
        ];
        $series[] = (object) [
            "type" => 'line',
            'name' => 'Illico_cash',
            'data' => $illicotab
        ];
        $series[] = (object) [
            "type" => 'area',
            'name' => 'Cash',
            'data' => $cashtab
        ];

        $data = [];
        if ('admin' == $user->user_role) {
            $data['nbchauffeurs'] = $nbchauffeurs;
            $data['nbagents'] = $nbagents;
            $data['nbadmins'] = $nbadmins;
            $data['topdrivers'] = $topdrivers;

            $data['cash'] = $cash;
            $data['illico_cash'] = $illico_cash;
            $data['carte_bancaire'] = $carte_bancaire;
            $data['mobile_money'] = $mobile_money;
        }

        if ('driver' == $user->user_role) {
            $profil = auth()->user()->profils()->first();
            $data['solde_usd']  = v($profil->solde_usd, 'USD');
            $data['solde_cdf']  = v($profil->solde_cdf, 'CDF');
        }

        $data['cemois'] = date('F');
        $data['recenttrans'] = $recenttrans;
        $data['transchart'] = $series;

        return $data;
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
