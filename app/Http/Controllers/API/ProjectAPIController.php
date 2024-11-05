<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Project;
use App\Models\ProjectHasUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ProjectAPIController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $t = Project::orderBy('status')->orderBy('id', 'desc')->get();
        $user = auth()->user();
        if ($user->user_role == 'student') {
            $t = $user->projects()->orderBy('status')->orderBy('id', 'desc')->get();
        }
        $data = [];

        foreach ($t as $el) {
            $o = (object)$el->toArray();
            $o->budget = v($el->budget, 'CDF');
            $o->budgetv = $el->budget;
            $o->startdate = $el->startdate?->format('Y-m-d H:i');
            $o->enddate = $el->enddate?->format('Y-m-d H:i');
            $o->users_id = $el->users()->pluck('id')->all();

            $perc = 100;
            $task1 = $el->tasks()->where('status', 1)->count();
            $task0 = $el->tasks()->where('status', 0)->count();
            $tot = $task0 + $task1;

            if ($tot) {
                $perc = (int) (($task1 / $tot) * 100);
            }
            $o->progress = $perc;
            $data[] = $o;
        }
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
            'name' => 'required',
            'date' => 'required',
            'budget' => 'required|numeric|min:0',
            'description' => 'sometimes',
            'users_id' => 'sometimes|array',
            'users_id.*' => 'exists:users,id',
        ];

        $validator = Validator::make(request()->all(), $rules);

        if ($validator->fails()) {
            return [
                'message' => implode(" ", $validator->errors()->all())
            ];
        }

        $data  = $validator->validated();

        $d = request('date');
        $d = explode(' to ', $d);
        $stard = $d[0];
        $endd = @$d[1] ?? $stard;

        DB::beginTransaction();

        $data['startdate'] = $stard;
        $data['enddate'] = $endd;
        $data['status'] = 0;
        $project = Project::create($data);

        foreach ((array) request('users_id') as $el) {
            ProjectHasUser::create(['users_id' => $el, 'project_id' => $project->id]);
        }
        DB::commit();

        return ['success' => true, 'message' => 'Project créé.'];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Project $project)
    {
        $rules =  [
            'name' => 'required',
            'date' => 'required',
            'budget' => 'required|numeric|min:0',
            'description' => 'sometimes',
            'users_id' => 'sometimes|array',
            'users_id.*' => 'exists:users,id',
        ];

        $addprod = request('yesno') == 1 and request()->has('finish');
        if ($addprod) {
            $rules = array_merge(
                $rules,
                [
                    'category_id' => 'required|exists:category,id',
                    'articlename' => 'required',
                    'articledescription' => 'sometimes',
                    'articleprice' => 'required|numeric|min:1',
                    'articlestock' => 'required|numeric|min:1',
                    'articleimage' => 'sometimes|array',
                    'articleimage.*' => 'mimes:jpeg,jpg,png|max:500',
                    'forsale' => 'sometimes',
                ]
            );
        }

        if ($addprod and !request()->has('articleimage')) {
            return [
                'message' => "Veuillez ajoute une image de l'article."
            ];
        }

        $validator = Validator::make(request()->all(), $rules);

        if ($validator->fails()) {
            return [
                'message' => implode(" ", $validator->errors()->all())
            ];
        }

        $data  = $validator->validated();

        $d = request('date');
        $d = explode(' to ', $d);
        $stard = $d[0];
        $endd = @$d[1] ?? $stard;

        DB::beginTransaction();

        $data['startdate'] = $stard;
        $data['enddate'] = $endd;
        $data['status'] = request()->has('finish');
        $project->update($data);

        ProjectHasUser::where(['project_id' => $project->id])->delete();
        foreach ((array) request('users_id') as $el) {
            ProjectHasUser::create(['users_id' => $el, 'project_id' => $project->id]);
        }

        $data2 = [];
        if ($addprod) {
            $i = [];
            foreach (request('articleimage') as $file) {
                $i[] = $file->store('image', 'public');
            }
            $data2['images'] = json_encode($i);
            $data2['forsale'] = request()->has('forsale');
            $data2['name'] = ucfirst(request('articlename'));
            Product::create($data);
        }

        $data2['description'] = request('articledescription');
        $data2['category_id'] = request('category_id');
        $data2['price'] = request('articleprice');
        $data2['stock'] = request('articlestock');
        $data2['project_id'] = $project->id;
        Product::create($data2);
        DB::commit();
        return ['success' => true, 'message' => 'Project mis à jour.'];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        abort_if($project->status == 1, 403);
        $project->delete();
        return ['success' => true, 'message' => 'Projet supprimé'];
    }
}
