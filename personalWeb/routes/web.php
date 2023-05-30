<?php

use App\Http\Controllers\PortofolioController;
use App\Http\Controllers\WebController;
use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/',[WebController::class,'index'])->name('display');
Route::get('/admin',[WebController::class,'admin'])->middleware(Authenticate::class)->name('admin');
Route::get('/myLogout',[WebController::class,'myLogout'])->name('myLogout');

Auth::routes([
    'register'=>false,
    'confirm' => false
]);

Route::get('/home/portView/{id}', [App\Http\Controllers\HomeController::class, 'portView'])->name('portView');

Route::resource('/portofolios','App\Http\Controllers\PortofolioController')->middleware(Authenticate::class);
