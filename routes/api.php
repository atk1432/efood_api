<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProductController;
use App\Http\Controllers\SocialAuthController;
use App\Http\Controllers\TypeController;

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
Route::apiResource('types', TypeController::class);


Route::prefix('auth')
->controller(SocialAuthController::class)
->name('auth.')
->group(function () {

    // Google 
    Route::get('/google/redirect', 'google_redirect')->name('google');
    Route::get('/google/callback', 'google_callback')->name('google');

    // Facebook


    // Get refresh token
    Route::get('/refresh', 'get_refresh_token')->name('get_refresh_token');

});

Route::get('/user', function (Request $request) {
    return auth()->user();
})->middleware('auth:api');
