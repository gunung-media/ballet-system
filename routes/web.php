<?php

use App\Http\Controllers\Sales\CategoryController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('pages.index');
})->name('dashboard');


Route::resource('kategori', CategoryController::class);
