<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AgentController extends Controller
{
    function __construct()
    {
        $this->middleware(function ($request, $next) {
            $role = auth()->user()->user_role;
            abort_if($role != 'agent', 403);
            return $next($request);
        });
    }

    function home()
    {
        return view('agent.home');
    }

    function profile()
    {
        return view('agent.profile');
    }
    function transactions()
    {
        return view('agent.transactions');
    }
    function transactions_new()
    {
        $chauffeurs = User::where('user_role', 'driver')->orderBy('name')->get();
        $img = User::where('user_role', 'driver')->orderBy('name')->get();
        $t = [];

        foreach ($img as $el) {
            $i = $el->image;
            if ($i) {
                $i =   asset('storage/' . $i);
            } else {
                $i =   asset('/assets/images/faces/9.jpg');
            }
            $t[$el->id] = $i;
        }
        $img = json_encode($t);
        return view('agent.transactions_new', compact('chauffeurs', 'img'));
    }
}
