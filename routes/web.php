<?php

use App\Http\Controllers\ChirpController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\Login;
use App\Http\Controllers\Auth\Logout;
use App\Http\Controllers\Auth\Register;

// Guest routes - Exercise 5 requirement
Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
   
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

// Auth route
Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

Route::get('/', [ChirpController::class, 'index']);

Route::middleware(['auth', 'throttle:6,1'])->group(function () {
    Route::post('/chirps', [ChirpController::class, 'store'])->name('chirps.store');
    
    // IMPORTANT: trash must be BEFORE {chirp} routes
    Route::get('/chirps/trash', [ChirpController::class, 'trash'])->name('chirps.trash');
   
    Route::get('/chirps/{chirp}/edit', [ChirpController::class, 'edit'])->name('chirps.edit');
    Route::put('/chirps/{chirp}', [ChirpController::class, 'update'])->name('chirps.update');
    Route::delete('/chirps/{chirp}', [ChirpController::class, 'destroy'])->name('chirps.destroy');
    Route::put('/chirps/{chirp}/restore', [ChirpController::class, 'restore'])->name('chirps.restore');
    Route::delete('/chirps/{chirp}/force-delete', [ChirpController::class, 'forceDelete'])->name('chirps.forceDelete');
});

//require __DIR__.'/auth.php';

 // Registration routes
Route::view('/register', 'auth.register')
    ->middleware('guest')
    ->name('register');
Route::post('/register', Register::class)
    ->middleware('guest')   // <-- add this
    ->name('register.store');

// Login routes
Route::view('/login', 'auth.login')
    ->middleware('guest')
    ->name('login');
Route::post('/login', Login::class)
    ->middleware('guest')   // <-- add this
    ->name('login.store');

// Logout route
Route::post('/logout', Logout::class)
    ->middleware('auth')
    ->name('logout');   

Route::middleware('auth')->group(function () {
    Route::post('/chirps', [ChirpController::class, 'store'])->name('chirps.store');
});
