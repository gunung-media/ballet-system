<?php

use App\Http\Controllers\Authentication\UserAuthController;
use App\Http\Controllers\Course\StudentController;
use App\Http\Controllers\Sales\CategoryController;
use Illuminate\Support\Facades\Route;

Route::name('auth.')->group(function () {
    Route::middleware('guest')->group(function () {
        Route::get('login', [UserAuthController::class, 'showLoginForm'])->name('login');
        Route::post('login', [UserAuthController::class, 'login'])->name('login.post');
    });
    Route::get('logout', [UserAuthController::class, 'logout'])->name('logout')->middleware('auth');
});


Route::middleware('auth')->group(function () {
    Route::get('/', function () {
        return view('pages.index');
    })->name('dashboard');

    Route::resource('kategori', CategoryController::class);

    Route::resources([
        'kategori' => CategoryController::class,
        'siswa' => StudentController::class
    ]);
});
