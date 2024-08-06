<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AttendanceController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', [AuthController::class, 'index']);

Route::middleware('auth')->group(function () 
    {

        Route::get('/', [AuthController::class, 'index']);
        Route::post('/start', [AttendanceController::class, 'startWork']);
        Route::post('/end', [AttendanceController::class, 'endWork']);
        
    });

// Route::post('/attendances', [AttendanceController::class, 'store']);