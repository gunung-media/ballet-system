<?php

use App\Http\Controllers\Authentication\StudentRegisterController;
use App\Http\Controllers\Authentication\UserAuthController;
use App\Http\Controllers\Course\AbsenceController;
use App\Http\Controllers\Course\ClassController;
use App\Http\Controllers\Course\StudentController;
use App\Http\Controllers\Course\TeacherController;
use App\Http\Controllers\Course\TuitionTransactionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Sales\CategoryController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;


Route::name('auth.')->group(function () {
    Route::get('register', [StudentRegisterController::class, 'register'])->name('register');
    Route::post('register_post', [StudentRegisterController::class, 'registerPost'])->name('register.post');

    Route::middleware('guest')->group(function () {
        Route::get('login', [UserAuthController::class, 'showLoginForm'])->name('login');
        Route::post('login', [UserAuthController::class, 'login'])->name('login.post');
    });
    Route::get('logout', [UserAuthController::class, 'logout'])->name('logout')->middleware('auth');
});


Route::middleware('auth')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('kategori', CategoryController::class)->except('show');

    Route::resource('siswa', StudentController::class)->except('show');
    Route::post('siswa/change_status/{id}', [StudentController::class, 'changeStatus'])->name('siswa.change-status');
    Route::resource('kelas', ClassController::class)->except('show');
    Route::resource('guru', TeacherController::class)->except('show');
    Route::resource('spp', TuitionTransactionController::class)->except('show');

    Route::get('/absence', [AbsenceController::class, 'index'])->name('absence.index');
    Route::get('/absence/form', [AbsenceController::class, 'form'])->name('absence.form');
    Route::post('/absence/form/submit', [AbsenceController::class, 'submit'])->name('absence.form.submit');
});
