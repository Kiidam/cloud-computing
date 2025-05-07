<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\CloudServiceController;
use App\Http\Controllers\Api\SecurityMeasureController;
use App\Http\Controllers\Api\SecurityIncidentController;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::middleware('api')->group(function () {
    Route::apiResource('users', UserController::class);
    Route::apiResource('cloud-services', CloudServiceController::class);
    Route::apiResource('security-measures', SecurityMeasureController::class);
    Route::apiResource('security-incidents', SecurityIncidentController::class);
});

Route::get("/hola", function () {
    return response()->json([
        "message" => "Hola desde la API de Laravel!",
    ]);
});
