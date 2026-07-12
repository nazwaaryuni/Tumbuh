<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DivisionController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\ProgramController;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\DueController;
use App\Http\Controllers\ExpenseBudgetController;
Route::get('/', function () {
    return view('welcome');
});

Route::middleware('guest')->group(function () {
    Route::get('/', [LoginController::class, 'index'])->name('login');
    Route::post('/authenticate', [LoginController::class, 'authenticate'])->name('login.authenticate');
});

Route::middleware('auth')->group(function () {
    Route::get('/logout', [LoginController::class, 'logout'])->name('login.logout');
    Route::post('/switch-user', [LoginController::class, 'switchUser'])->name('login.switch_user');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
    Route::get('/dashboard/show', [DashboardController::class, 'show'])->name('dashboard.show');
    Route::get('/dashboard/edit', [DashboardController::class, 'edit'])->name('dashboard.edit');
    Route::put('/dashboard/update', [DashboardController::class, 'update'])->name('dashboard.update');

    Route::resource('/user', UserController::class)->middleware('can:manage-users');
    
    Route::resource('/division', DivisionController::class);
    Route::resource('/position', PositionController::class);
    Route::resource('/member', MemberController::class);
    Route::resource('/program', ProgramController::class);
    
    Route::resource('/activities', ActivityController::class);
    Route::get('/attendances', [AttendanceController::class, 'globalIndex'])->name('attendances.index');
    Route::get('/activities/{activity}/attendances', [AttendanceController::class, 'index'])->name('activities.attendances.index');
    Route::post('/activities/{activity}/attendances', [AttendanceController::class, 'store'])->name('activities.attendances.store');

    Route::get('/activities/{activity}/budgets', [ExpenseBudgetController::class, 'index'])->name('activities.budgets.index');
    Route::post('/activities/{activity}/budgets', [ExpenseBudgetController::class, 'store'])->name('activities.budgets.store');
    Route::put('/activities/{activity}/budgets/{budget}', [ExpenseBudgetController::class, 'update'])->name('activities.budgets.update');
    Route::delete('/activities/{activity}/budgets/{budget}', [ExpenseBudgetController::class, 'destroy'])->name('activities.budgets.destroy');

    Route::get('/dues', [DueController::class, 'index'])->name('dues.index');
    Route::post('/dues', [DueController::class, 'store'])->name('dues.store');

    Route::get('/setting', [SettingController::class, 'index'])->name('setting.index')->middleware('can:manage-settings');
    Route::put('/setting/{setting}/update', [SettingController::class, 'update'])->name('setting.update')->middleware('can:manage-settings');
});
