<?php

use App\Http\Controllers\Api\LicenciaController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Foundation\Http\Middleware\HandlePrecognitiveRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Route::apiResource('licencias', LicenciaController::class)->middleware([HandlePrecognitiveRequests::class]);
Route::middleware(['web', 'auth', HandlePrecognitiveRequests::class])->group(function () {
    Route::apiResource('licencias', LicenciaController::class);
});
Route::get('usuarios/estado/{usuario}', [UserController::class, 'cambiarEstado'])->middleware([HandlePrecognitiveRequests::class]);
Route::apiResource('usuarios', UserController::class)->middleware([HandlePrecognitiveRequests::class]);