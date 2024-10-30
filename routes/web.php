<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AgentController;
use App\Http\Controllers\AppController;
use App\Http\Controllers\DriverController;
use App\Models\Pay;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    if (Auth::check()) {
        $role = auth()->user()->user_role;
        $url = '';
        if ($role == 'admin') {
            $url = route('admin.home');
        } elseif ($role == 'user') {
            $url = route('user.home');
        } elseif ($role == 'agent') {
            $url = route('agent.home');
        } else {
            Auth::logout();
            abort(403);
        }

        $r = request('r');
        if ($r) {
            $url = urldecode($r);
        }
        return redirect($url);
    }
    return view('login');
})->name('login');


Route::post('auth/login', [AppController::class, 'login'])->name('auth-login');
Route::post('auth/logout', [AppController::class, 'logout'])->name('auth-logout');

Route::middleware('auth')->group(function () {
    Route::prefix('admin')->group(function () {
        Route::controller(AdminController::class)->group(function () {
            Route::get('',  'home')->name('admin.home');
            Route::get('projects',  'projects')->name('admin.projects');
            Route::get('admins',  'admins')->name('admin.admins');
            Route::get('students',  'students')->name('admin.students');
            Route::get('profile',  'profile')->name('admin.profile');
            Route::get('degree',  'degree')->name('admin.degree');
            Route::get('products',  'products')->name('admin.products');
            Route::get('category',  'category')->name('admin.category');
            Route::get('users',  'users')->name('admin.users');
        });
    });

    Route::prefix('user')->group(function () {
        Route::controller(DriverController::class)->group(function () {
            Route::get('',  'home')->name('user.home');
            Route::get('transactions',  'transactions')->name('user.transactions');
            Route::get('profile',  'profile')->name('user.profile');
        });
    });

    Route::prefix('agent')->group(function () {
        Route::controller(AgentController::class)->group(function () {
            Route::get('',  'home')->name('agent.home');
            Route::get('transactions',  'transactions')->name('agent.transactions');
            Route::get('transactions/new',  'transactions_new')->name('agent.transactions-new');
            Route::get('profile',  'profile')->name('agent.profile');
            Route::get('users',  'users')->name('agent.users');
        });
    });
});

Route::any('checkout', function () {
    abort_if(!auth()->check(), 401);
    abort_if(auth()->user()->user_role != 'agent', 403);

    $pd = Pay::where('ref', request('ref'))->first();
    if (!$pd or @$pd->saved == 1) {
        return redirect(route('agent.transactions'));
    }
    return view('pay', compact('pd'));
})->name('pay');
