<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ShowExchangeRates;
use App\Http\Controllers\ShowExchangeRatesByDay;
use App\Http\Controllers\ShowExchangeRatesByRange;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('latest', ShowExchangeRates::class);

Route::get('history/{start}/{end}', ShowExchangeRatesByRange::class);

Route::get('{time}', ShowExchangeRatesByDay::class);
