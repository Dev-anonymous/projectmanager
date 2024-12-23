<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use App\Models\Category;
use App\Models\Commande;
use App\Models\Exportation;
use App\Models\Filiere;
use App\Models\FiliereHasPromotion;
use App\Models\Invoice;
use App\Models\InvoicePay;
use App\Models\Project;
use App\Models\Promotion;
use App\Models\Support;
use App\Models\User;
use App\Models\Validationcriterion;
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

    function students()
    {
        $promotion = FiliereHasPromotion::with(['promotion' => function ($q) {
            $q->orderBy('promotion');
        }])->with(['filiere' => function ($q) {
            $q->orderBy('filiere');
        }])->get();
        return view('admin.students', compact('promotion'));
    }

    function users()
    {
        return view('admin.user');
    }

    function profile()
    {
        return view('admin.profile');
    }
    function degree()
    {
        $promotion = Promotion::orderBy('promotion')->get();
        $filiere = Filiere::orderBy('filiere')->get();
        return view('admin.degree', compact('promotion', 'filiere'));
    }
    function category()
    {
        return view('admin.category');
    }
    function products()
    {
        $project = Project::orderBy('name')->get();
        $category = Category::orderBy('category')->get();
        return view('admin.product', compact('project', 'category'));
    }
    function projects()
    {
        $students = User::where('user_role', 'student')->orderBy('name')->get();
        $project = Project::orderBy('name')->get();
        $category = Category::orderBy('category')->get();

        $item = request('item');
        $pro = Project::where('id', $item)->first();
        if ($pro) {
            $project = $pro;
            $students = $pro->users()->orderBy('name')->get();
            return view('admin.projectdetails', compact('students', 'project', 'category'));
        }
        $criteria = Validationcriterion::orderBy('criteria')->get();

        return view('admin.projects', compact('students', 'project', 'category', 'criteria'));
    }

    function order()
    {
        $order =  Commande::orderBy('id', 'desc')->get();
        return view('admin.order', compact('order'));
    }

    function criteria()
    {
        return view('admin.criteria');
    }
}
