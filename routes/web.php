<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\FilialController;
use App\Http\Controllers\CookiesController;
use App\Http\Controllers\HodimController;
use App\Http\Controllers\UserController;

Route::get('/', [HomeController::class, 'index']);

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/setCookie', [CookiesController::class, 'setCookie'])->name('setCookie');
Route::get('/delCookie', [CookiesController::class, 'delCookie'])->name('delCookie');
Route::get('/changeFilial', [CookiesController::class, 'changeFilial'])->name('changeFilial');
Route::get('/changeFilial/{id}/{name}', [CookiesController::class, 'changeFilialEdit'])->name('changeFilialEdit');

Route::resource('filial', FilialController::class);
Route::get('hodim-lock', [HodimController::class, 'hodimLock'])->name('hodimLock');
Route::get('hodim-open/{id}', [HodimController::class, 'LockOpen'])->name('LockOpen');
Route::get('hodim-colse/{id}', [HodimController::class, 'LockClose'])->name('LockClose');
Route::resource('hodim', HodimController::class);

Route::get('userDebet', [UserController::class, 'userDebet'])->name('userDebet');
Route::get('userPay', [UserController::class, 'userPay'])->name('userPay');
Route::resource('user', UserController::class);