<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\FiliereHasPromotion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class FacultAPIController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = FiliereHasPromotion::with(['promotion' => function ($q) {
            $q->orderBy('promotion');
        }])->with(['filiere' => function ($q) {
            $q->orderBy('filiere');
        }])->withCount('users')->get();
        return [
            'success' => true,
            'data' => $data
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
        $rules =  [
            'filiere_id' => 'required|exists:filiere,id',
            'promotion_id' => 'required|array',
            'promotion_id.*' => 'required|exists:promotion,id',
        ];

        $validator = Validator::make(request()->all(), $rules);

        if ($validator->fails()) {
            return [
                'message' => implode(" ", $validator->errors()->all())
            ];
        }

        $data  = $validator->validated();

        DB::beginTransaction();
        $fi = request('filiere_id');
        $pr = request('promotion_id');

        foreach ($pr as $el) {
            if (!FiliereHasPromotion::where(['filiere_id' => $fi, 'promotion_id' => $el])->first()) {
                FiliereHasPromotion::create(['filiere_id' => $fi, 'promotion_id' => $el]);
            }
        }
        DB::commit();

        return ['success' => true, 'message' => 'Données créées avec succès.'];
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
    public function destroy(FiliereHasPromotion $faculte)
    {
        if ($n = $faculte->users()->count()) {
            return [
                'message' => "Cette faculté a déjà $n étudiant(s), vous devez supprimer tous les étudiants de cette faculté d'abord."
            ];
        }

        $faculte->delete();
        return ['success' => true, 'message' => 'Suppression éffectuée !'];
    }
}
