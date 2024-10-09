<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DriverController extends Controller
{
    function __construct()
    {
        $this->middleware(function ($request, $next) {
            $role = auth()->user()->user_role;
            abort_if($role != 'driver', 403);
            return $next($request);
        });
    }

    function home()
    {
        return view('driver.home');
    }

    function profile()
    {
        return view('driver.profile');
    }
    function transactions()
    {
        return view('driver.transactions');
    }
}
