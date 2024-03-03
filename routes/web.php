<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\FilialController;
use App\Http\Controllers\CookiesController;

Route::get('/', [HomeController::class, 'index']);

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/setCookie', [CookiesController::class, 'setCookie'])->name('setCookie');
Route::get('/delCookie', [CookiesController::class, 'delCookie'])->name('delCookie');
Route::get('/changeFilial', [CookiesController::class, 'changeFilial'])->name('changeFilial');
Route::get('/changeFilial/{id}/{name}', [CookiesController::class, 'changeFilialEdit'])->name('changeFilialEdit');




Route::resource('filial', FilialController::class);