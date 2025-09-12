<?php

use App\Http\Controllers\Api\LicenciaController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('licencias', LicenciaController::class);