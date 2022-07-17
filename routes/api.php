<?php

use App\Http\Controllers\CostumerController;
use App\Http\Controllers\DashboardController;
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

Route::post('costumers', [CostumerController::class, 'createCostumer']);
Route::get('dashboard', [DashboardController::class, 'fakeData']);
