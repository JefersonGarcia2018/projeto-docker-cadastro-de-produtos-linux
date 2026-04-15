<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProdutoController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\VeiculoController;
use App\Http\Controllers\ServicoController;
use App\Http\Controllers\DashboardController;

Route::post('/auth/register', [AuthController::class, 'register']);
Route::post('/auth/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    
    Route::get('/auth/me', [AuthController::class, 'me']);
    Route::post('/auth/logout', [AuthController::class, 'logout']);
    
    Route::apiResource('produtos', ProdutoController::class);
    Route::apiResource('clientes', ClienteController::class);
    Route::apiResource('veiculos', VeiculoController::class);
    Route::apiResource('servicos', ServicoController::class);
    
    Route::get('/dashboard', [DashboardController::class, 'index']);
});

Route::get('/v1/status', function () {
    return response()->json([
        'status' => 'online',
        'versao' => 'Laravel X',
        'ambiente' => 'Docker/Ubuntu'
    ]);
});