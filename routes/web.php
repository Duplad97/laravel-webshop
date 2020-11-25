<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\MainController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AdminController;

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

//GET
Route::get('/', [MainController::class, 'index'])->name('main');

Route::get('/menu', [ItemController::class, 'showAll'])->name('menu');
Route::get('/menu/category/{id}', [ItemController::class, 'show'])->name('category');

Route::get('/about', [AboutController::class, 'show'])->name('about');

Route::get('/cart', [CartController::class, 'show'])->name('cart')->middleware('auth');

Route::get('/profile', [ProfileController::class, 'show'])->name('profile')->middleware('auth');

Route::get('/orders', [OrderController::class, 'show'])->name('orders')->middleware('auth');

Route::get('/admin/category/new', [AdminController::class, 'newCategory'])->name('new.category')->middleware('auth');
Route::get('/admin/category/{id}/edit', [AdminController::class, 'editCategory'])->name('edit.category')->middleware('auth');

Route::get('/admin/item/new', [AdminController::class, 'newItem'])->name('new.item')->middleware('auth');
Route::get('/admin/item/{id}/edit', [AdminController::class, 'editItem'])->name('edit.item')->middleware('auth');
Route::get('/admin/manage/received', [AdminController::class, 'receivedOrders'])->name('received.orders')->middleware('auth');
Route::get('/admin/manage/processed', [AdminController::class, 'processedOrders'])->name('processed.orders')->middleware('auth');
Route::get('/admin/manage/order/{id}', [AdminController::class, 'showOrder'])->name('show.order')->middleware('auth');

//POST
Route::post('/cart/add/{itemId}',[CartController::class, 'addToCart'])->name('add.to.cart')->middleware('auth');
Route::post('/cart/send', [CartController::class, 'sendOrder'])->name('send.order')->middleware('auth');

Route::post('/admin/category/store', [AdminController::class, 'storeCategory'])->name('store.category')->middleware('auth');
Route::post('/admin/category/{id}/update', [AdminController::class, 'updateCategory'])->name('update.category')->middleware('auth');

Route::post('/admin/item/store', [AdminController::class, 'storeItem'])->name('store.item')->middleware('auth');
Route::post('/admin/item/{id}/update', [AdminController::class, 'updateItem'])->name('update.item')->middleware('auth');
Route::post('/admin/item/{id}/delete', [AdminController::class, 'deleteItem'])->name('delete.item')->middleware('auth');
Route::post('/admin/item/{id}/restore', [AdminController::class, 'restoreItem'])->name('restore.item')->middleware('auth');
Route::post('/admin/manage/reject/{id}', [AdminController::class, 'rejectOrder'])->name('reject.order')->middleware('auth');
Route::post('/admin/manage/accept/{id}', [AdminController::class, 'acceptOrder'])->name('accept.order')->middleware('auth');

//DELETE
Route::delete('/cart/remove/{itemId}', [CartController::class, 'removeFromCart'])->name('remove.from.cart')->middleware('auth');

Route::delete('/admin/category/{id}/delete', [AdminController::class, 'deleteCategory'])->name('delete.category')->middleware('auth');

Auth::routes();