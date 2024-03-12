<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\FilialController;
use App\Http\Controllers\CookiesController;
use App\Http\Controllers\HodimController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TecherController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\ProfelController;
use App\Http\Controllers\SendMessgeController; 
use App\Http\Controllers\SettingController; 
use App\Http\Controllers\GuruhController; 
use App\Http\Controllers\GuruhUserController; 
use App\Http\Controllers\EslatmaController; 

Route::get('/', [TecherController::class, 'index']);
Route::get('/SendMessege/{phone}/{text}', [SendMessgeController::class, 'SendMessege'])->name('SendMessege');

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/setCookie', [CookiesController::class, 'setCookie'])->name('setCookie');
Route::get('/delCookie', [CookiesController::class, 'delCookie'])->name('delCookie');
Route::get('/changeFilial', [CookiesController::class, 'changeFilial'])->name('changeFilial');
Route::get('/changeFilial/{id}/{name}', [CookiesController::class, 'changeFilialEdit'])->name('changeFilialEdit');

Route::resource('filial', FilialController::class);
Route::get('hodim-lock', [HodimController::class, 'hodimLock'])->name('hodimLock');
Route::post('sendmes', [HodimController::class, 'sendMessege'])->name('sendmes');
Route::get('hodim-open/{id}', [HodimController::class, 'LockOpen'])->name('LockOpen');
Route::get('hodim-colse/{id}', [HodimController::class, 'LockClose'])->name('LockClose');
Route::resource('hodim', HodimController::class);

Route::get('userDebet', [UserController::class, 'userDebet'])->name('userDebet');
Route::get('userPay', [UserController::class, 'userPay'])->name('userPay');
Route::post('changePassword', [UserController::class, 'userPasswordUpdate'])->name('userPasswordUpdate');
Route::post('userSmsSenf', [UserController::class, 'userSendMessge'])->name('userSendMessge');
Route::resource('user', UserController::class);

Route::get('techerLock', [TecherController::class, 'techerLock'])->name('techerLock');
Route::get('techerLockopen/{id}', [TecherController::class, 'techerLockopen'])->name('techerLockopen');
Route::get('techerLockClose/{id}', [TecherController::class, 'techerLockClose'])->name('techerLockClose');
Route::resource('techer', TecherController::class);

Route::resource('room', RoomController::class);

Route::get('profel-statistik', [ProfelController::class, "Statistika"])->name('Statistika');
Route::get('profel-ish-haqi', [ProfelController::class, "IshHaqi"])->name('IshHaqi');
Route::resource('profel', ProfelController::class);

Route::post('setting-setting', [SettingController::class, 'testCreate'])->name('testCreate');
Route::get('test-false/{id}', [SettingController::class, 'testFalse'])->name('testFalse');
Route::get('test-edit/{id}', [SettingController::class, 'edit'])->name('testEdit');
Route::resource('setting', SettingController::class);

Route::get('guruh_activ', [GuruhController::class, 'indexActiv'])->name('indexActiv');
Route::get('guruh_new', [GuruhController::class, 'indexNew'])->name('indexNew');
Route::get('guruh_create2/{id}', [GuruhController::class, 'create2'])->name('create2');
Route::post('guruh_store2', [GuruhController::class, 'store2'])->name('store2');
Route::delete('guruh_delete/{id}', [GuruhController::class, 'distroy2'])->name('distroy2');
Route::resource('guruh', GuruhController::class);

Route::post('guruh_setting/sendMessege', [GuruhUserController::class, 'sendMessege'])->name('sendMessege');
Route::resource('guruh_setting', GuruhUserController::class);


Route::post('eslatma/EslatmaUser', [EslatmaController::class,"EslatmaUser"])->name('EslatmaUser');
Route::get('eslatma/arxiv', [EslatmaController::class,"arxivEslatma"])->name('arxivEslatma');
Route::resource('eslatma', EslatmaController::class);
