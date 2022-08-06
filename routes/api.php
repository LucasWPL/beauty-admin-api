<?php

use App\Http\Controllers\CostumerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\ProcedureController;
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

Route::get('dashboard', [DashboardController::class, 'cardsData']);

/**
 * Costumers init
 */

Route::get('costumers', [CostumerController::class, 'getAllCostumers']);
Route::get('costumers/{id}', [CostumerController::class, 'getCostumer']);
Route::post('costumers', [CostumerController::class, 'createCostumer']);
Route::put('costumers/{id}', [CostumerController::class, 'updateCostumer']);
Route::delete('costumers/{id}', [CostumerController::class, 'deleteCostumer']);

/**
 * Costumers end
 */

/**
 * Jobs init
 */

Route::get('jobs', [JobController::class, 'getAllJobs']);
Route::get('jobs/{id}', [JobController::class, 'getJob']);
Route::post('jobs', [JobController::class, 'createJob']);
Route::put('jobs/{id}', [JobController::class, 'updateJob']);
Route::delete('jobs/{id}', [JobController::class, 'deleteJob']);

/**
 * Jobs end
 */

/**
 * Procedure init
 */

Route::get('procedures', [ProcedureController::class, 'getAllProcedures']);
Route::get('procedures/{id}', [ProcedureController::class, 'getProcedure']);
Route::post('procedures', [ProcedureController::class, 'createProcedure']);
Route::put('procedures/{id}', [ProcedureController::class, 'updateProcedure']);
Route::delete('procedures/{id}', [ProcedureController::class, 'deleteProcedure']);

/**
 * Procedure end
 */
