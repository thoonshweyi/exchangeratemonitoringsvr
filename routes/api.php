<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CurrenciesControler;
use App\Http\Controllers\Api\ExchangeDocusController;
use App\Http\Controllers\Api\ExchangeRatesController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/register',[AuthController::class,"register"]);
Route::post('/login',[AuthController::class,"login"]);

Route::apiResource("currencies",CurrenciesControler::class,["as"=>"api"]);
Route::put("/currenciesstatus",[CurrenciesControler::class,"typestatus"]);

Route::post('/logout',[AuthController::class,"logout"])->middleware("auth:api");
Route::middleware(["auth:api"])->group(function(){
    Route::get('/me',[AuthController::class,"me"]);

    Route::get("/exchangedocustodaydashboard",[ExchangeDocusController::class,"todayDashboard"]);
    Route::get("/exchangedocusweeklydashboard",[ExchangeDocusController::class,"weeklyDashboard"]);

    Route::apiResource("exchangedocus",ExchangeDocusController::class,["as"=>"api"]);


    Route::apiResource("exchangerates",ExchangeDocusController::class,["as"=>"api"]);
    Route::get("/exchangerates/{id}/detail",[ExchangeRatesController::class,"detail"]);

});

