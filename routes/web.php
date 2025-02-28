<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BannerController;

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

Route::get('/', [BannerController::class, 'index']);
Route::post('upload', [BannerController::class, 'upload']);
Route::delete('/image/{id}', [BannerController::class, 'destroy'])->name('image.delete');
