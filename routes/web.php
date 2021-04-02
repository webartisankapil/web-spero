<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/home', [ProductController::class, 'index'])->name('home');

Route::get('/products', [ProductController::class, 'getProducts']);
Route::get('/products/{id}', [ProductController::class, 'show']);

Route::get('/cart', [CartController::class, 'index'])->middleware('auth');
Route::get('/cart/count-items', [CartController::class, 'countItems']);
Route::post('/cart/add', [CartController::class, 'add']);
Route::get('/cart/items', [CartController::class, 'getItems']);
Route::post('/cart/remove', [CartController::class, 'removeItem']);
Route::post('/cart/update', [CartController::class, 'updateItem']);
