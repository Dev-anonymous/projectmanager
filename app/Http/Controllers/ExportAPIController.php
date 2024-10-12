<?php

namespace App\Http\Controllers;

use App\Models\Exportation;
use Illuminate\Http\Request;

class ExportAPIController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Exportation::orderBy('etat')->orderBy('id', 'desc')->get();
        
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Exportation  $exportation
     * @return \Illuminate\Http\Response
     */
    public function show(Exportation $exportation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Exportation  $exportation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Exportation $exportation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Exportation  $exportation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Exportation $exportation)
    {
        //
    }
}
