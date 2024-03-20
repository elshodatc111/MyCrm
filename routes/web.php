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
use App\Http\Controllers\TolovController; 
use App\Http\Controllers\MoliyaController; 

Route::get('/', [HomeController::class, 'index'])->middleware('auth');
Route::get('/SendMessege/{phone}/{text}', [SendMessgeController::class, 'SendMessege'])->name('SendMessege')->middleware('auth');

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home')->middleware('auth');
Route::get('/setCookie', [CookiesController::class, 'setCookie'])->name('setCookie')->middleware('auth');
Route::get('/delCookie', [CookiesController::class, 'delCookie'])->name('delCookie')->middleware('auth');
Route::get('/changeFilial', [CookiesController::class, 'changeFilial'])->name('changeFilial')->middleware('auth');
Route::get('/changeFilial/{id}/{name}', [CookiesController::class, 'changeFilialEdit'])->name('changeFilialEdit')->middleware('auth');

Route::resource('filial', FilialController::class)->middleware('auth');
Route::get('hodim-lock', [HodimController::class, 'hodimLock'])->name('hodimLock')->middleware('auth');
Route::post('sendmes', [HodimController::class, 'sendMessege'])->name('sendmes')->middleware('auth');
Route::get('hodim-open/{id}', [HodimController::class, 'LockOpen'])->name('LockOpen')->middleware('auth');
Route::get('hodim-colse/{id}', [HodimController::class, 'LockClose'])->name('LockClose')->middleware('auth');
Route::resource('hodim', HodimController::class)->middleware('auth');

Route::post('tulov/chegirma/destroy', [UserController::class,"chegirmadestroy"])->name('chegirmadestroy')->middleware('auth');
Route::get('userDebet', [UserController::class, 'userDebet'])->name('userDebet')->middleware('auth');
Route::get('userPay', [UserController::class, 'userPay'])->name('userPay')->middleware('auth');
Route::post('changePassword', [UserController::class, 'userPasswordUpdate'])->name('userPasswordUpdate')->middleware('auth');
Route::post('userSmsSenf', [UserController::class, 'userSendMessge'])->name('userSendMessge')->middleware('auth');
Route::post('userAdminChegirma', [UserController::class, 'userAdminChegirma'])->name('userAdminChegirma')->middleware('auth');
Route::resource('user', UserController::class)->middleware('auth');

Route::get('techerLock', [TecherController::class, 'techerLock'])->name('techerLock')->middleware('auth');
Route::get('techerLockopen/{id}', [TecherController::class, 'techerLockopen'])->name('techerLockopen')->middleware('auth');
Route::get('techerLockClose/{id}', [TecherController::class, 'techerLockClose'])->name('techerLockClose')->middleware('auth');
Route::resource('techer', TecherController::class)->middleware('auth');

Route::resource('room', RoomController::class)->middleware('auth');

Route::get('profel-statistik', [ProfelController::class, "Statistika"])->name('Statistika')->middleware('auth');
Route::get('profel-ish-haqi', [ProfelController::class, "IshHaqi"])->name('IshHaqi')->middleware('auth');
Route::resource('profel', ProfelController::class)->middleware('auth');

Route::post('setting-setting', [SettingController::class, 'testCreate'])->name('testCreate')->middleware('auth');
Route::get('test-false/{id}', [SettingController::class, 'testFalse'])->name('testFalse')->middleware('auth');
Route::get('test-edit/{id}', [SettingController::class, 'edit'])->name('testEdit')->middleware('auth');
Route::resource('setting', SettingController::class)->middleware('auth');

Route::get('guruh_activ', [GuruhController::class, 'indexActiv'])->name('indexActiv')->middleware('auth');
Route::get('guruh_new', [GuruhController::class, 'indexNew'])->name('indexNew')->middleware('auth');
Route::PUT('guruh_new/create/{id}', [GuruhController::class, 'indexNewCreate'])->name('indexNewCreate')->middleware('auth');
Route::get('guruh_new/NewGuruh', [GuruhController::class, 'NewGuruh'])->name('NewGuruh')->middleware('auth');
Route::put('guruh_new/NewGuruh', [GuruhController::class, 'NewGuruhUpdate'])->name('NewGuruhUpdate')->middleware('auth');
Route::get('guruh_create2/{id}', [GuruhController::class, 'create2'])->name('create2')->middleware('auth');
Route::post('guruh_store2', [GuruhController::class, 'store2'])->name('store2')->middleware('auth');
Route::post('guruh/tulov/qaytarish', [GuruhController::class, 'tulovQaytarish'])->name('tulovQaytarish')->middleware('auth');
Route::delete('guruh_delete/{id}', [GuruhController::class, 'distroy2'])->name('distroy2')->middleware('auth');
Route::resource('guruh', GuruhController::class)->middleware('auth');

Route::post('guruh_setting/sendMessege', [GuruhUserController::class, 'sendMessege'])->name('sendMessege')->middleware('auth');
Route::resource('guruh_setting', GuruhUserController::class)->middleware('auth');


Route::post('eslatma/EslatmaUser', [EslatmaController::class,"EslatmaUser"])->name('EslatmaUser')->middleware('auth');
Route::get('eslatma/arxiv', [EslatmaController::class,"arxivEslatma"])->name('arxivEslatma')->middleware('auth');
Route::resource('eslatma', EslatmaController::class)->middleware('auth');

Route::resource('tulov', TolovController::class)->middleware('auth');

Route::get('moliya/naqt', [MoliyaController::class,"naqtMoliya"])->name('naqtMoliya')->middleware('auth');
Route::post('moliya/edit/{id}', [MoliyaController::class,"CheckEdit"])->name('CheckEdit')->middleware('auth'); // To'lovni tasdiqlash
Route::post('moliya/delete/{id}', [MoliyaController::class,"CheckDestroy"])->name('CheckDestroy')->middleware('auth'); // To'lovni o'chirish
Route::get('moliya/naqt', [MoliyaController::class,"naqtMoliya"])->name('naqtMoliya')->middleware('auth');
Route::get('moliya/plastik', [MoliyaController::class,"plastikMoliya"])->name('plastikMoliya')->middleware('auth');
Route::get('moliya/qaytarildi', [MoliyaController::class,"qaytarildiMoliya"])->name('qaytarildiMoliya')->middleware('auth');
Route::resource('moliya', MoliyaController::class)->middleware('auth');
