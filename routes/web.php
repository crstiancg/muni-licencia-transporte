<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LicenciaController;
use App\Http\Controllers\UserController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// Route::get('/', function () {
//     return Inertia::render('Welcome', [
//         'canLogin' => Route::has('login'),
//         'canRegister' => Route::has('register'),
//         'laravelVersion' => Application::VERSION,
//         'phpVersion' => PHP_VERSION,
//     ]);
// });
Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('welcome');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/licencias', [LicenciaController::class,'index'])->name('licencias.index');
    Route::resource('/usuarios', UserController::class);
});
Route::get('/licencias/consulta', [LicenciaController::class,'consulta']);

// Route::get('/licencia', [LicenciaController::class])->;