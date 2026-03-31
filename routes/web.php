<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('login', [AuthController::class, 'index']);
Route::get('register', [AuthController::class, 'indexRegister'])->middleware('guest');

Route::get('products', [ProductController::class, 'showProducts']);