<?php

use Illuminate\Http\Request;

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

Route::prefix('api/v1')->group(function () {
    Route::middleware(['auth:admin_api'])->group(function () {
        Route::prefix('admin')->group(function () {
            Route::name('travellog.admin.')->group(function () {
                ////////////////////////////////////////////////////////////
                /// PLACE ADMIN API ROUTES HERE ////////////////////////////
                ////////////////////////////////////////////////////////////
                Route::apiResource('itineraries', 'Mchljams\TravelLog\Http\Controllers\API\ItineraryController');
                ////////////////////////////////////////////////////////////
            });
        });
    });

    Route::middleware(['auth:api'])->group(function () {
        Route::name('travellog.')->group(function () {
            ////////////////////////////////////////////////////////////
            /// PLACE PUBLIC API ROUTES HERE ///////////////////////////
            ////////////////////////////////////////////////////////////
            Route::get('/user', function (Request $request) {
                return $request->user();
            })->name('user.show');
            Route::apiResource('itineraries', 'Mchljams\TravelLog\Http\Controllers\API\ItineraryController');
            ////////////////////////////////////////////////////////////
        });
    });
});



