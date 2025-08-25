<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::middleware(['api'])->prefix('auth/')->group(function (){
    Route::post('logout', [AuthController::class, 'logout'])->middleware('api');
    Route::post('refresh', [AuthController::class, 'refresh'])->middleware('api');
    Route::get('user', [AuthController::class, 'user'])->middleware('api');
});

Route::post('auth/login', [AuthController::class, 'login']);

?>