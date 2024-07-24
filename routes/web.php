<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/user', [DashboardController::class, 'user'])->name('dashboard.user');
    Route::get('/dashboard/user/create', [DashboardController::class, 'userCreate'])->name('dashboard.user.create');
    Route::post('/dashboard/user/store', [DashboardController::class, 'userStore'])->name('dashboard.user.store');
    Route::get('/dashboard/user/{user}/edit', [DashboardController::class, 'userEdit'])->name('dashboard.user.edit');
    Route::put('/dashboard/user/{user}/update', [DashboardController::class, 'userUpdate'])->name('dashboard.user.update');
    Route::delete('/dashboard/user/{user}/destroy', [DashboardController::class, 'userDestroy'])->name('dashboard.user.destroy');
});
