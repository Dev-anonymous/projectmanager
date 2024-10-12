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
        } elseif ($role == 'driver') {
            $url = route('driver.home');
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
            Route::get('transactions',  'transactions')->name('admin.transactions');
            Route::get('export',  'export')->name('admin.export');
            Route::get('admins',  'admins')->name('admin.admins');
            Route::get('agents',  'agents')->name('admin.agents');
            Route::get('drivers',  'drivers')->name('admin.drivers');
            Route::get('settings',  'settings')->name('admin.settings');
            Route::get('profile',  'profile')->name('admin.profile');
        });
    });

    Route::prefix('driver')->group(function () {
        Route::controller(DriverController::class)->group(function () {
            Route::get('',  'home')->name('driver.home');
            Route::get('transactions',  'transactions')->name('driver.transactions');
            Route::get('profile',  'profile')->name('driver.profile');
        });
    });

    Route::prefix('agent')->group(function () {
        Route::controller(AgentController::class)->group(function () {
            Route::get('',  'home')->name('agent.home');
            Route::get('transactions',  'transactions')->name('agent.transactions');
            Route::get('transactions/new',  'transactions_new')->name('agent.transactions-new');
            Route::get('profile',  'profile')->name('agent.profile');
            Route::get('drivers',  'drivers')->name('agent.drivers');
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
