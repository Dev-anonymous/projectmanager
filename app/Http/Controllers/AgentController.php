<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
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

    function users()
    {
        $categories = Categorie::orderBy('categorie')->get();
        return view('agent.users', compact('categories'));
    }
    function transactions_new()
    {
        $chauffeurs = User::where('user_role', 'user')->orderBy('name')->get();
        $img = User::where('user_role', 'user')->orderBy('name')->get();
        $t = [];

        foreach ($img as $el) {
            $t[$el->id] = userimage($el);
        }
        $img = json_encode($t);
        return view('agent.transactions_new', compact('chauffeurs', 'img'));
    }
}
