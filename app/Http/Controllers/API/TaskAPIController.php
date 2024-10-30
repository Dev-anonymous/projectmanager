<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\TaskHasUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class TaskAPIController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $project_id = request('project_id');

        $t = Task::orderBy('status')->orderBy('id', 'desc');
        if ($project_id) {
            $t->where(compact('project_id'));
        }
        $data = [];

        foreach ($t->get() as $el) {
            $o = (object)$el->toArray();
            $o->startdate = $el->startdate?->format('Y-m-d H:i');
            $o->enddate = $el->enddate?->format('Y-m-d H:i');
            $o->users = $el->users()->pluck('name')->all();
            $o->users_id = $el->users()->pluck('id')->all();
            $o->project = $el->project->name;
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
            'description' => 'required',
            'users_id' => 'required|array',
            'users_id.*' => 'exists:users,id',
            'project_id' => 'required|exists:project,id',
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

        $task = Task::create($data);
        foreach ((array) request('users_id') as $el) {
            TaskHasUser::create(['users_id' => $el, 'task_id' => $task->id]);
        }
        DB::commit();

        return ['success' => true, 'message' => 'Tache créée.'];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function show(Task $task)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Task $task)
    {
        $rules =  [
            'name' => 'required',
            'date' => 'required',
            'description' => 'required',
            'users_id' => 'required|array',
            'users_id.*' => 'exists:users,id',
            'id' => 'required|exists:task,id',
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
        $data['status'] = request()->has('finish');
        $task->update($data);
        TaskHasUser::where(['task_id' => $task->id])->delete();
        foreach ((array) request('users_id') as $el) {
            TaskHasUser::create(['users_id' => $el, 'task_id' => $task->id]);
        }
        DB::commit();

        return ['success' => true, 'message' => 'Tache mis à jour.'];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function destroy(Task $task)
    {
        abort_if($task->status == 1, 403);
        $task->delete();
        return ['success' => true, 'message' => 'Tache supprimée'];
    }
}
