<?php

use App\Http\Controllers\Authentication\StudentRegisterController;
use App\Http\Controllers\Authentication\UserAuthController;
use App\Http\Controllers\Course\AbsenceController;
use App\Http\Controllers\Course\ClassController;
use App\Http\Controllers\Course\StudentController;
use App\Http\Controllers\Course\TeacherController;
use App\Http\Controllers\Course\TuitionTransactionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmployeeAbsenceController;
use App\Http\Controllers\EmployeeAuthController;
use App\Http\Controllers\InstallmentController;
use App\Http\Controllers\InstallmentPaymentController;
use App\Http\Controllers\Sales\CategoryController;
use App\Http\Controllers\SettingController;
use App\Http\Middleware\EmployeeAuth;
use Illuminate\Support\Facades\Route;


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
    Route::resource('kelas', ClassController::class);
    Route::resource('guru', TeacherController::class)->except('show');
    Route::resource('spp', TuitionTransactionController::class)->except('show');
    Route::get('cetak-spp', [TuitionTransactionController::class, 'cetakSpp'])->name('spp.cetak-spp');
    Route::get('/get-classes/{studentId}', [TuitionTransactionController::class, 'getClasses'])->name('spp.get-classes');

    Route::get('/absence', [AbsenceController::class, 'index'])->name('absence.index');
    Route::get('/absence/form', [AbsenceController::class, 'form'])->name('absence.form');
    Route::post('/absence/form/submit', [AbsenceController::class, 'submit'])->name('absence.form.submit');

    Route::prefix('setting')->name('setting.')->group(function () {
        Route::get('/', [SettingController::class, 'index'])->name('index');
        Route::post('/', [SettingController::class, 'store'])->name('store');
    });

    Route::resource('installment', InstallmentController::class)->except('installment');
    Route::prefix('installment/{installmentId}/payment')->name('installment.payment.')->group(function () {
        Route::get('/', [InstallmentPaymentController::class, 'create'])->name('create');
        Route::post('/', [InstallmentPaymentController::class, 'store'])->name('store');
        Route::get('/{installmentPaymentId}', [InstallmentPaymentController::class, 'edit'])->name('edit');
        Route::put('/{installmentPaymentId}', [InstallmentPaymentController::class, 'update'])->name('update');
        Route::delete('/{installmentPaymentId}', [InstallmentPaymentController::class, 'destroy'])->name('destroy');
    });

    // Route::resource('pegawai', EmployeeController::class)->except('show');

    // Route::name('pegawai.absence.')->prefix('pegawai/absence')->group(function () {
    //     Route::get('/', [EmployeeAbsenceController::class, 'index'])->name('index');
    //     Route::get('form', [EmployeeAbsenceController::class, 'form'])->name('form');
    //     Route::post('form/submit', [EmployeeAbsenceController::class, 'submit'])->name('form.submit');
    // });
});


Route::prefix('staf')->name('employee.')->group(function () {
    Route::get('login', [EmployeeAuthController::class, 'showLoginForm'])->name('login');
    Route::post('login', [EmployeeAuthController::class, 'login'])->name('login');
    Route::middleware(EmployeeAuth::class)->group(function () {
        Route::get('logout', [EmployeeAuthController::class, 'logout'])->name('logout');
        Route::get('/', [EmployeeAuthController::class, 'index'])->name('index');
        Route::post('/check-in', [EmployeeAbsenceController::class, 'checkIn'])->name('absence.checkin');
        Route::post('/check-out', [EmployeeAbsenceController::class, 'checkOut'])->name('absence.checkout');
    });
});
