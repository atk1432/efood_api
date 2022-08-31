<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProductController;
use App\Http\Controllers\SocialAuthController;
use App\Http\Controllers\TypeController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ResponseController;
use App\Http\Controllers\EconController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;

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

Route::apiResource('products.comments', CommentController::class);
Route::get('/products/{product}/other-comments', [CommentController::class, 'other_comments']);

Route::apiResource('types', TypeController::class);

Route::get('/responses/{id}/{db}', [ResponseController::class, 'index']);
Route::post('/responses/{id}/{db}', [ResponseController::class, 'store']);

Route::apiResource('carts', CartController::class);
Route::get('/carts-amount', [CartController::class, 'amount']);

Route::apiResource('orders', OrderController::class);

Route::prefix('sendEcon')
->controller(EconController::class)
->group(function () {

    Route::post('/{db}', 'send_econ');

});


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


    // Logout
    Route::get('/logout', 'logout')->name('logout');

});

Route::get('/user', function (Request $request) {
    return auth()->user();
})->middleware('auth:api');
