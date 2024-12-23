<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Projectcriterion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ProjectCritriaAPIController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
            'id' => 'required|exists:project,id',
            'projectcriteria_id' => 'required|array',
            'projectcriteria_id.*' => 'exists:projectcriteria,id',
            'quota' => 'required|array',
            'quota.*' => 'numeric|min:0|max:10',
        ];

        $validator = Validator::make(request()->all(), $rules);

        if ($validator->fails()) {
            return [
                'message' => implode(" ", $validator->errors()->all())
            ];
        }
        $data  = $validator->validated();

        $cri = request('projectcriteria_id');
        $q = request('quota');
        $pro = request('id');

        if (count($cri) != count($q)) {
            abort(403);
        }

        $tot = array_sum($q) / count($q);
        $tot = round($tot, 2);
        abort_if($tot > 10, 403);

        DB::beginTransaction();
        $v = 0;
        if ($tot >= 5) {
            $v = 1;
        } elseif ($tot < 5) {
            $v = 2;
        }
        Project::where('id', $pro)->update(['quote' => $tot, 'valide' => $v]);

        foreach ($cri as $k => $el) {
            $n = $q[$k];
            $o = Projectcriterion::where(['id' => $el, 'project_id' => $pro])->update(['quota' => $n]);
        }
        DB::commit();

        return ['success' => true, 'message' => "Projet validé ! note de validation : $tot/10"];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Projectcriterion  $projectcriterion
     * @return \Illuminate\Http\Response
     */
    public function show(Projectcriterion $projectcriterion)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Projectcriterion  $projectcriterion
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Projectcriterion $projectcriterion)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Projectcriterion  $projectcriterion
     * @return \Illuminate\Http\Response
     */
    public function destroy(Projectcriterion $projectcriterion)
    {
        //
    }
}
