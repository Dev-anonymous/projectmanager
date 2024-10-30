<?php

use App\Http\Controllers\API\CategoryAPIController;
use App\Http\Controllers\API\ConfigAPIController;
use App\Http\Controllers\API\DashAPIController;
use App\Http\Controllers\API\DepotAPIController;
use App\Http\Controllers\API\ExportAPIController;
use App\Http\Controllers\API\FacultAPIController;
use App\Http\Controllers\API\ProductAPIController;
use App\Http\Controllers\API\ProjectAPIController;
use App\Http\Controllers\API\TaskAPIController;
use App\Http\Controllers\API\TauxAPIController;
use App\Http\Controllers\API\UsersController;
use App\Http\Controllers\AppController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::resource('users', UsersController::class)->only(['index', 'store', 'destroy']);
    Route::post('users/{user}', [UsersController::class, 'update']);
    Route::resource('dash', DashAPIController::class)->only(['index']);
    Route::resource('config', ConfigAPIController::class)->only(['store']);
    Route::resource('faculte', FacultAPIController::class);
    Route::resource('category', CategoryAPIController::class)->only(['index', 'store', 'destroy']);
    Route::post('category/{category}', [CategoryAPIController::class, 'update']);
    Route::resource('product', ProductAPIController::class)->only(['index', 'store', 'destroy']);
    Route::post('product/{product}', [ProductAPIController::class, 'update']);
    Route::resource('project', ProjectAPIController::class)->only(['index', 'store', 'destroy']);
    Route::post('project/{project}', [ProjectAPIController::class, 'update']);
    Route::resource('task', TaskAPIController::class);

    Route::post('cpa', [AppController::class, 'cpa'])->name('cpa');
    Route::post('fpi', [AppController::class, 'fpi'])->name('fpi');
    Route::post('fpc', [AppController::class, 'fpc'])->name('fpc');
    Route::post('sti', [AppController::class, 'sti'])->name('sti');
    Route::post('cmi', [AppController::class, 'cmi'])->name('cmi');
    Route::post('smc', [AppController::class, 'smc'])->name('smc');
});
