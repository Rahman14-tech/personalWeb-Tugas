<?php

use App\Http\Controllers\APIController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::group([

    'middleware' => 'auth:api',
    'prefix' => 'auth'

], function ($router) {
    Route::post('login', [ApiController::class, 'login']);
    Route::get('portfolios', [APIController::class, 'index']);
    Route::post('portfolios', [APIController::class, 'store']);
    Route::post('portfolios/{id}', [APIController::class, 'update']);
    Route::post('logout', [ApiController::class, 'logout']);

});