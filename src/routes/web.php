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

        Route::get('/', [AuthController::class, 'index'])->name('home');
        Route::post('/startwork', [AttendanceController::class, 'startWork'])->name('startWork');
        Route::post('/endwork', [AttendanceController::class, 'endWork'])->name('endWork');
        Route::post('/startbreak', [AttendanceController::class, 'startBreak'])->name('startBreak');
        Route::post('/endbreak', [AttendanceController::class, 'endBreak'])->name('endBreak');
        // Route::get('/attendances', [AttendanceController::class, 'index']);
        Route::get('/attendances', [AttendanceController::class,'showByDate'])->name('showByDate');
    });


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
