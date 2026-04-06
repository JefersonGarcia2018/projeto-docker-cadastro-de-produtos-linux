<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProdutoController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/v1/status', function () {
    return response()->json([
        'status' => 'online',
        'versao' => 'Laravel X',
        'ambiente' => 'Docker/Ubuntu'
    ]);
});

Route::apiResource('produtos', ProdutoController::class);