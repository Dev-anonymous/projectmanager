<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\InvoicePay;
use App\Models\Support;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    function __construct()
    {
        $this->middleware(function ($request, $next) {
            $role = auth()->user()->user_role;
            abort_if($role != 'admin', 403);
            return $next($request);
        });
    }

    function home()
    {
        return view('admin.home');
    }

    function admins()
    {
        return view('admin.admins');
    }
    function agents()
    {
        return view('admin.agents');
    }

    function drivers()
    {
        return view('admin.drivers');
    }

    function settings()
    {
        return view('admin.settings');
    }

    function profile()
    {
        return view('admin.profile');
    }
    function transactions()
    {
        return view('admin.transactions');
    }
}
