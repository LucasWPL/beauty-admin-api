<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CostumerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\ProcedureController;
use Illuminate\Support\Facades\Route;

Route::get('dashboard', [DashboardController::class, 'cardsData'])->middleware('auth:sanctum');

Route::controller(AuthController::class)->group(function () {
    Route::post('register', 'register');
    Route::post('login', 'login');
    Route::post('logout', 'logout')->middleware('auth:sanctum');
});

Route::controller(CostumerController::class)->middleware('auth:sanctum')->group(function () {
    Route::get('costumers', 'getAllCostumers');
    Route::get('costumers/{id}', 'getCostumer');
    Route::post('costumers', 'createCostumer');
    Route::put('costumers/{id}', 'updateCostumer');
    Route::delete('costumers/{id}', 'deleteCostumer');
});

Route::controller(JobController::class)->middleware('auth:sanctum')->group(function () {
    Route::get('jobs', 'getAllJobs');
    Route::get('jobs/{id}', 'getJob');
    Route::post('jobs', 'createJob');
    Route::put('jobs/{id}', 'updateJob');
    Route::delete('jobs/{id}', 'deleteJob');
});

Route::controller(ProcedureController::class)->middleware('auth:sanctum')->group(function () {
    Route::get('procedures', 'getAllProcedures');
    Route::get('procedures/{id}', 'getProcedure');
    Route::post('procedures', 'createProcedure');
    Route::put('procedures/{id}', 'updateProcedure');
    Route::delete('procedures/{id}', 'deleteProcedure');
});
