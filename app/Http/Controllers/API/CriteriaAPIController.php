<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Validationcriterion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CriteriaAPIController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $t = Validationcriterion::orderBy('criteria')->get();
        return [
            'success' => true,
            'data' => $t
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
            'criteria' => 'required|unique:validationcriteria,criteria',
        ];

        $validator = Validator::make(request()->all(), $rules);

        if ($validator->fails()) {
            return [
                'message' => implode(" ", $validator->errors()->all())
            ];
        }
        $data  = $validator->validated();
        Validationcriterion::create($data);

        return ['success' => true, 'message' => 'Critère créé.'];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Validationcriterion  $validationcriterion
     * @return \Illuminate\Http\Response
     */
    public function show(Validationcriterion $validationcriterion)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Validationcriterion  $validationcriterion
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Validationcriterion $criterion)
    {
        $rules =  [
            'criteria' => 'required|unique:validationcriteria,criteria,' . $criterion->id,
        ];

        $validator = Validator::make(request()->all(), $rules);

        if ($validator->fails()) {
            return [
                'message' => implode(" ", $validator->errors()->all())
            ];
        }
        $data  = $validator->validated();
        $criterion->update($data);

        return ['success' => true, 'message' => 'Critère mise à jour.'];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Validationcriterion  $validationcriterion
     * @return \Illuminate\Http\Response
     */
    public function destroy(Validationcriterion $criterion)
    {
        $criterion->delete();
        return ['success' => true, 'message' => 'Critère supprimé'];
    }
}
