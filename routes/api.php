<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProductController;
use App\Http\Controllers\SocialAuthController;


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


Route::apiResource('products', ProductController::class);

Route::prefix('auth')
->controller(SocialAuthController::class)
->name('auth.')
->group(function () {

    // Google 
    Route::get('/google/redirect', 'google_redirect')->name('google');
    Route::get('/google/callback', 'google_callback')->name('google');


    // Facebook

});

Route::get('/test', function (Request $request) {
    return auth()->user();
})->middleware('auth:api');
