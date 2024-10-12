<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Exportation;
use App\Models\ExportationHasProfil;
use App\Models\Pending;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ExportAPIController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $t = Exportation::orderBy('etat')->orderBy('id', 'desc')->get();

        $data = [];
        foreach ($t as $el) {
            $o = (object) [];
            $o->btn = $el->user->id == auth()->user()->id;
            $o->id = $el->id;
            $o->etat = $el->etat;
            $o->name = $el->user->name;
            $o->image = userimage($el->user);
            $o->montant_cdf = v($el->montant_cdf, 'CDF');
            $o->montant_usd = v($el->montant_usd, 'USD');
            $o->date = $el->date?->format('d-m-Y H:i:s');
            $o->datevalidation = $el->user->datevalidation?->format('d-m-Y H:i:s');
            $data[] = $o;
        }

        return [
            'success' => true,
            'data' => $data
        ];
    }


    function preview()
    {
        $users = (array) request('users_id');
        $t = User::whereIn('id', $users)->where('user_role',  'user')->orderBy('name')->get();

        $data = [];
        foreach ($t as $el) {
            $o = (object)$el->toArray();
            $pro = $el->profils()->first();
            if ($pro) {
                $o->solde_cdf = v($pro->solde_cdf, 'CDF');
                $o->cdf = $pro->solde_cdf;
                $o->solde_usd = v($pro->solde_usd, 'USD');
                $o->usd = $pro->solde_usd;
            }
            $o->image = userimage($el);
            $o->categorie = $el->categorie->categorie;
            $data[] = $o;
        }

        return [
            'success' => true,
            'data' => $data,
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
        $validator = Validator::make(request()->all(), [
            'users_id' => 'required|array',
            'users_id.*' => 'exists:users,id',
            'amount_cdf' => 'required|array',
            'amount_cdf.*' => 'numeric|min:0',
            'amount_usd' => 'required|array',
            'amount_usd.*' => 'numeric|min:0',
        ]);

        if ($validator->fails()) {
            return [
                'message' => implode(" ", $validator->errors()->all())
            ];
        }

        $data  = $validator->validated();

        $userids = request('users_id');
        $cdf = request('amount_cdf');
        $usd = request('amount_usd');

        abort_if(count($userids) != count($cdf), 403);
        abort_if(count($usd) != count($cdf), 403);

        $expo = Exportation::where('etat', 0)->lockForUpdate()->first();
        if (!$expo) {
            $expo = Exportation::create([
                'users_id' => auth()->user()->id,
                'etat' => 0
            ]);
        } else {
            return [
                'message' => "Vous devez d'abort supprimer ou valider l'exportation en cours avant d'en créer une autre."
            ];
        }

        $totcdf = $totusd = 0;

        DB::beginTransaction();
        ExportationHasProfil::where('exportation_id', $expo->id)->delete();

        foreach ($userids as $k => $el) {
            $user = User::find($el);
            $pro = $user->profils()->first();
            $solcdf = $pro->solde_cdf;
            $solusd = $pro->solde_usd;

            $vcdf = (float) $cdf[$k];
            $vusd = (float) $usd[$k];

            abort_if($solcdf < $vcdf or $solusd < $vusd, 403);
            abort_if($vcdf > $solcdf or $vusd > $solusd, 403);

            if (!$vcdf and !$vusd) {
                $expo->delete();
                return [
                    'message' => "Combien voulez vous envoyer pour le client $user->name ? "
                ];
            }

            ExportationHasProfil::create([
                'profil_id' => $pro->id,
                'exportation_id' => $expo->id,
                'montant_cdf' => $vcdf,
                'montant_usd' => $vusd,
            ]);

            $totcdf += $vcdf;
            $totusd += $vusd;
        }

        $expo->update([
            'montant_cdf' => $totcdf,
            'montant_usd' => $totusd,
            'date' => nnow(),
        ]);
        DB::commit();

        return [
            'success' => true,
            'message' => "Exportation créée; veuillez exporter le fichier EXCEL puis valider l'exportation."
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Exportation  $exportation
     * @return \Illuminate\Http\Response
     */
    public function show(Exportation $export)
    {
        $data = [];

        foreach ($export->profils()->with('user')->get() as $el) {
            $o = (object) [];
            $o->name = $el->user->name;
            $o->code = $el->user->code;
            $o->phone = $el->user->phone;

            $cdf = $el->pivot->montant_cdf;
            $usd = $el->pivot->montant_usd;
            $m = [];
            if ($usd) {
                $m[] = v($usd, 'USD');
            }
            if ($cdf) {
                $m[] = v($cdf, 'CDF');
            }
            $o->montant = $m;
            $data[] = $o;
        }

        return [
            'success' => true,
            'data' => $data,
        ];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Exportation  $exportation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Exportation $export)
    {
        abort_if($export->etat == 1, 403);
        abort_if($export->user->id != auth()->user()->id, 403);

        DB::beginTransaction();

        foreach ($export->profils()->with('user')->get() as $el) {
            $cdf = $el->pivot->montant_cdf;
            $usd = $el->pivot->montant_usd;

            abort_if($el->solde_cdf < $cdf, 400, 'Solde cdf');
            abort_if($el->solde_usd < $usd, 400, 'Solde usd');
            $el->decrement('solde_cdf', $cdf);
            $el->decrement('solde_usd', $usd);
            $m = [];
            if ($cdf) {
                $m[] = v($cdf, 'CDF');
            }
            if ($usd) {
                if (count($m)) {
                    $m[] = ' et ' .  v($usd, 'USD');
                } else {
                    $m[] =  v($usd, 'USD');
                }
            }
            $m = implode('', $m);
            $txt = "Le solde de votre compte a été  déduit de $m.";
            $phone = $el->user->phone;
            if ('yes' == getconfig('sms')) {
                Pending::create(['to' => $phone, 'text' => $txt, 'retry' => 0]);
            }
        }
        $export->update(['etat' => 1, 'datevalidation' => nnow()]);

        DB::commit();
        return [
            'success' => true,
            'message' => 'Transaction validée.'
        ];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Exportation  $exportation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Exportation $export)
    {
        abort_if($export->etat == 1, 403);
        abort_if($export->user->id != auth()->user()->id, 403);
        $export->delete();
        return [
            'success' => true,
            'message' => 'Exportation supprimée'
        ];
    }
}
