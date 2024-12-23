<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AgentController;
use App\Http\Controllers\AppController;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\UserController;
use App\Models\Category;
use App\Models\Pay;
use Illuminate\Support\Facades\Route;


Route::get('/login', function () {
    if (Auth::check()) {
        $role = auth()->user()->user_role;
        $url = '';
        if ($role == 'admin') {
            $url = route('admin.home');
        } elseif ($role == 'user') {
            $url = route('home');
        } elseif ($role == 'student') {
            $url = route('student.home');
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

Route::get('/', function () {
    $categories = Category::withCount('products')->orderBy('category')->get();
    $topcat = DB::select("Select category.*, count(product.id) n from category JOIN product ON product.category_id=category.id group by category.id order by n desc limit 5");
    return view('home', compact('categories', 'topcat'));
})->name('home');

Route::post('auth/login', [AppController::class, 'login'])->name('auth-login');
Route::post('auth/logout', [AppController::class, 'logout'])->name('auth-logout');
Route::post('auth/new', [AppController::class, 'newu'])->name('auth-new');

Route::middleware('auth')->group(function () {
    Route::prefix('admin')->group(function () {
        Route::controller(AdminController::class)->group(function () {
            Route::get('',  'home')->name('admin.home');
            Route::get('projects',  'projects')->name('admin.projects');
            Route::get('criteria',  'criteria')->name('admin.criteria');
            Route::get('admins',  'admins')->name('admin.admins');
            Route::get('students',  'students')->name('admin.students');
            Route::get('profile',  'profile')->name('admin.profile');
            Route::get('degree',  'degree')->name('admin.degree');
            Route::get('products',  'products')->name('admin.products');
            Route::get('category',  'category')->name('admin.category');
            Route::get('order',  'order')->name('admin.order');
            Route::get('users',  'users')->name('admin.users');
        });
    });

    Route::prefix('user')->group(function () {
        Route::controller(UserController::class)->group(function () {
            Route::get('',  'home')->name('student.home');
            Route::get('profile',  'profile')->name('user.profile');
            Route::get('projects',  'projects')->name('user.projects');
            Route::get('order',  'order')->name('user.order');
        });
    });
});
