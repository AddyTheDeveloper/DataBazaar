<?php

use App\Http\Controllers\Api\MarketDataApiController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| These routes are loaded by the RouteServiceProvider and all of them will
| be assigned the "api" middleware group.
|
*/

Route::get('/market-data', [MarketDataApiController::class, 'index']);
Route::post('/market-data', [MarketDataApiController::class, 'store']);
Route::get('/products', [MarketDataApiController::class, 'products']);
