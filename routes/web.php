<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BukuController;

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

Route::get('/', [BukuController::class, 'index']);
Route::get('/buku', [BukuController::class, 'buku']);
Route::post('/buku', [BukuController::class, 'store'])->name('buku.store');
Route::delete('/buku/delete{id}', [BukuController::class, 'destroy'])->name('buku.destroy');
Route::put('/buku/update/{id}', [BukuController::class, 'update'])->name('buku.update');
Route::put('/buku', [BukuController::class, 'search'])->name('buku.search');
