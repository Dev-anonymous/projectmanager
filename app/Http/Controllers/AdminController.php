<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use App\Models\Exportation;
use App\Models\Invoice;
use App\Models\InvoicePay;
use App\Models\Support;
use App\Models\User;
use Illuminate\Http\Request;
use Shuchkin\SimpleXLSXGen;

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

    function users()
    {
        $categories = Categorie::orderBy('categorie')->get();
        return view('admin.users', compact('categories'));
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

    function category()
    {
        return view('admin.category');
    }

    function export()
    {
        $users = User::where('user_role', 'user')->orderBy('name')->whereHas('profils', function ($q) {
            $q->where('solde_cdf', '>', 0);
            $q->orWhere('solde_usd', '>', 0);
        })->get();
        return view('admin.export', compact('users'));
    }

    function excel()
    {
        $idxport = request('el');
        $export = Exportation::findOrFail($idxport);

        $data = [
            ['TO_MOBILE_NUMBER', 'AMOUNT', 'CURRENCY'],
        ];
        foreach ($export->profils()->with('user')->get() as $el) {
            $o = (object) [];
            $cdf = $el->pivot->montant_cdf;
            $usd = $el->pivot->montant_usd;
            $phone = $el->user->phone;

            if ($usd) {
                $line = [];
                $line[] = $phone;
                $line[] = $usd;
                $line[] = 'USD';
                $data[] = $line;
            }

            if ($cdf) {
                $line = [];
                $line[] = $phone;
                $line[] = $cdf;
                $line[] = 'CDF';
                $data[] = $line;
            }
        }
        $name = "Exportation_$export->id\_{$export->date?->format('d-m-Y')}";
        SimpleXLSXGen::fromArray($data)->downloadAs("$name.xlsx");
    }
}
