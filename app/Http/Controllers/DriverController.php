<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DriverController extends Controller
{
    function __construct()
    {
        $this->middleware(function ($request, $next) {
            $role = auth()->user()->user_role;
            abort_if($role != 'user', 403);
            return $next($request);
        });
    }

    function home()
    {
        return view('user.home');
    }

    function profile()
    {
        return view('user.profile');
    }
    function transactions()
    {
        return view('user.transactions');
    }
}
