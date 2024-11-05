<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use App\Models\Project;
use App\Models\ProjectHasUser;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    function __construct()
    {
        $this->middleware(function ($request, $next) {
            $role = auth()->user()->user_role;
            abort_if(!in_array($role, ['user', 'student']), 403);
            return $next($request);
        });
    }

    function home()
    {
        return redirect(route('user.projects'));
    }
    function projects()
    {
        $item = request('item');
        $pro = Project::where('id', $item)->first();
        if ($pro) {
            $project = $pro;
            $students = $pro->users()->orderBy('name')->get();
            $tru = ProjectHasUser::where(['project_id' => $pro->id, 'users_id' => auth()->user()->id])->first();
            if ($tru) {
                return view('user.projectdetails', compact('students', 'project'));
            }
        }
        return view('user.projects');
    }

    function profile()
    {
        return view('user.profile');
    }

    function order()
    {
        $order = auth()->user()->commandes()->orderBy('id', 'desc')->get();
        return view('user.order', compact('order'));
    }
}
