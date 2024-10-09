<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Taux;
use Illuminate\Http\Request;

class TauxAPIController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $taux = Taux::first();
        $taux = (object) $taux->toArray();

        return $taux;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $to = request('to');
        $action = request('action');
        if ($action == 'setauto') {
            if ($to == 1 or $to == 0) {
                $taux = Taux::first();
                $taux->auto = $to;
                $taux->save();
                return ['success' => true, 'message' => 'Taux automatique mis à jour'];
            }
        }
        if ($action == 'remote') {
            remotetaux();
        }

        if ($action == 'update') {
            $cdfusd = request('cdf_usd');
            $usdcdf = request('usd_cdf');

            if ($cdfusd > 0 and $usdcdf > 0) {
                $taux = Taux::first();
                $taux->usd_cdf = $usdcdf;
                $taux->cdf_usd = $cdfusd;
                $taux->save();
                return ['success' => true, 'message' => 'Taux mis à jour'];
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Taux  $taux
     * @return \Illuminate\Http\Response
     */
    public function show(Taux $taux)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Taux  $taux
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Taux $taux)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Taux  $taux
     * @return \Illuminate\Http\Response
     */
    public function destroy(Taux $taux)
    {
        //
    }
}
