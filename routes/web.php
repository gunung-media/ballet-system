<?php

use App\Http\Controllers\Course\StudentController;
use App\Http\Controllers\Sales\CategoryController;
use Illuminate\Support\Facades\Route;

Route::get('/login', function () {
    return view('sign-in');
})->name('sign-in');

Route::get('/', function () {
    return view('pages.index');
})->name('dashboard');

Route::resource('kategori', CategoryController::class);

Route::resources([
    'kategori' => CategoryController::class,
    'siswa' => StudentController::class
]);
