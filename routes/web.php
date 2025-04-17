<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ImageController;



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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/upload-image', [Controller::class, 'uploadimage'])->name('upload-image');

Route::get('/array-sum', [Controller::class, 'sum'])->name('array-sum');

Route::get('/ksort-number', [Controller::class, 'findsortnumber'])->name('ksort-number');

Route::post('/twosum', [Controller::class, 'process'])->name('twosum.process');

Route::post('/kclosest', [Controller::class, 'kclosest'])->name('kclosest');



Route::get('/indeximage', [ImageController::class, 'index'])->name('indeximage');

Route::post('/upload', [ImageController::class, 'store'])->name('images.store');

Route::post('/images/clear', [ImageController::class, 'clear'])->name('images.clear');
