<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SchedulerController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/scheduler', [SchedulerController::class, 'addTask']);
Route::patch('/scheduler/{id}/status', [SchedulerController::class, 'updateStatus']);
Route::post('/scheduler/execute/{id}', [SchedulerController::class, 'executeTask']);
