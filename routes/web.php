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

Route::middleware('guest')->group(function () {
  Route::get('/register', [RegisterController::class, 'index']);
  Route::post('/register', [RegisterController::class, 'store']);
  
  Route::get('/login', [LoginController::class, 'index'])->name('login');
  Route::post('/login', [LoginController::class, 'auth']);
});

Route::middleware('auth')->group(function () {
  Route::post('/logout', [LogoutController::class, 'index']);

  Route::get('/', [HomeController::class, 'index']);
  
  Route::get('/user', [UserController::class, 'index']);
  Route::put('/user', [UserController::class, 'update']);
  
  Route::get('/product', [ProductController::class, 'productView']);
  Route::delete('/product', [ProductController::class, 'delete']);
  
  Route::get('/product/add', [ProductController::class, 'addView']);
  Route::post('/product/add', [ProductController::class, 'store']);
  
  Route::get('/product/edit', [ProductController::class, 'editView']);
  Route::put('/product/edit', [ProductController::class, 'update']);
  Route::get('/belanja', [BelanjaController::class, 'index']);

  Route::get('/keranjang', [KeranjangController::class, 'index']);
  Route::post('/keranjang', [KeranjangController::class, 'store']);
  Route::delete('/keranjang', [KeranjangController::class, 'delete']);
  Route::get('/keranjang/checked', [KeranjangController::class, 'checked']);
});

