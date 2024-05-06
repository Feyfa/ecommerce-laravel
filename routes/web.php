<?php

use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\BelanjaController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KeranjangController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\UserController;
use App\Models\Product;
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

Route::get('/register', [RegisterController::class, 'index'])->middleware('guest');
Route::post('/register', [RegisterController::class, 'store'])->middleware('guest');

Route::get('/login', [LoginController::class, 'index'])->name('login')->middleware('guest');
Route::post('/login', [LoginController::class, 'auth'])->middleware('guest');

Route::post('/logout', [LogoutController::class, 'index'])->middleware('auth');

Route::get('/', [HomeController::class, 'index'])->middleware('auth');

Route::get('/user', [UserController::class, 'index'])->middleware('auth');
Route::put('/user', [UserController::class, 'update'])->middleware('auth');

Route::get('/product', [ProductController::class, 'productView'])->middleware('auth');
Route::delete('/product', [ProductController::class, 'delete'])->middleware('auth');

Route::get('/product/add', [ProductController::class, 'addView'])->middleware('auth');
Route::post('/product/add', [ProductController::class, 'store'])->middleware('auth');

Route::get('/product/edit', [ProductController::class, 'editView'])->middleware('auth');
Route::put('/product/edit', [ProductController::class, 'update'])->middleware('auth');

Route::get('/belanja', [BelanjaController::class, 'index'])->middleware('auth');

Route::get('/keranjang', [KeranjangController::class, 'index'])->middleware('auth');
Route::post('/keranjang', [KeranjangController::class, 'store'])->middleware('auth');
Route::delete('/keranjang', [KeranjangController::class, 'delete'])->middleware('auth');
Route::get('/keranjang/checked', [KeranjangController::class, 'checked'])->middleware('auth');