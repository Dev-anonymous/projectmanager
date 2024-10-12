<?php

use App\Http\Controllers\API\ConfigAPIController;
use App\Http\Controllers\API\DashAPIController;
use App\Http\Controllers\API\DepotAPIController;
use App\Http\Controllers\API\TauxAPIController;
use App\Http\Controllers\API\UsersController;
use App\Http\Controllers\AppController;
use App\Http\Controllers\ExportAPIController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->group(function () {
    Route::resource('taux', TauxAPIController::class)->only(['index', 'store']);
    Route::resource('users', UsersController::class)->only(['index', 'store', 'destroy']);
    Route::post('users/{user}', [UsersController::class, 'update']);
    Route::resource('depot', DepotAPIController::class)->only(['index']);
    Route::resource('dash', DashAPIController::class)->only(['index']);
    Route::resource('config', ConfigAPIController::class)->only(['store']);
    Route::resource('export', ExportAPIController::class)->only(['index', 'store', 'destroy']);

    Route::post('cpa', [AppController::class, 'cpa'])->name('cpa');
    Route::post('fpi', [AppController::class, 'fpi'])->name('fpi');
    Route::post('fpc', [AppController::class, 'fpc'])->name('fpc');
    Route::post('sti', [AppController::class, 'sti'])->name('sti');
    Route::post('cmi', [AppController::class, 'cmi'])->name('cmi');
    Route::post('smc', [AppController::class, 'smc'])->name('smc');
});
