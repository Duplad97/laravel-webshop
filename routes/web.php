<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\MainController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\AboutController;
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

/*Route::get('/', function () {
    return view('welcome');
});*/

Route::get('/', [MainController::class, 'index'])->name('main');
Route::get('/menu', [ItemController::class, 'showAll'])->name('menu');
Route::get('/about', [AboutController::class, 'show'])->name('about');
Route::get('/cart', [CartController::class, 'show'])->name('cart')->middleware('auth');

Route::post('/cart/add/{itemId}',[CartController::class, 'addToCart'])->name('add.to.cart')->middleware('auth');

Route::delete('/cart/remove/{itemId}', [CartController::class, 'removeFromCart'])->name('remove.from.cart')->middleware('auth');

Auth::routes();