<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChartController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DocumentsController;
use App\Http\Controllers\ProgramsController;
use App\Http\Controllers\TimelineController;
use Illuminate\Support\Facades\Route;

Route::get('/', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::post('/dashboard/resource/chart', [ChartController::class, 'store'])->name('dashboard.chart.store');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/user', [DashboardController::class, 'user'])->name('dashboard.user');
    Route::get('/dashboard/user/create', [DashboardController::class, 'userCreate'])->name('dashboard.user.create');
    Route::post('/dashboard/user/store', [DashboardController::class, 'userStore'])->name('dashboard.user.store');
    Route::get('/dashboard/user/{user}/edit', [DashboardController::class, 'userEdit'])->name('dashboard.user.edit');
    Route::put('/dashboard/user/{user}/update', [DashboardController::class, 'userUpdate'])->name('dashboard.user.update');
    Route::delete('/dashboard/user/{user}/destroy', [DashboardController::class, 'userDestroy'])->name('dashboard.user.destroy');
    
    Route::get('/dashboard/resource/document', [DocumentsController::class, 'index'])->name('dashboard.document');
    Route::post('/dashboard/resource/documents', [DocumentsController::class, 'store'])->name('dashboard.document.store');
    Route::put('/dashboard/resource/documents/{document}', [DocumentsController::class, 'update'])->name('dashboard.document.update');
    Route::delete('/dashboard/resource/documents/{document}', [DocumentsController::class, 'destroy'])->name('dashboard.document.destroy');

    Route::get('/dashboard/resource/chart', [ChartController::class, 'index'])->name('dashboard.chart');
    Route::post('dashboard/chart/{id}/update', [ChartController::class, 'update'])->name('dashboard.chart.update');
    
    Route::get('/dashboard/resource/programs', [ProgramsController::class, 'index'])->name('dashboard.programs');
    Route::post('/dashboard/resource/programs', [ProgramsController::class, 'store'])->name('dashboard.programs.store');
    Route::put('/dashboard/resource/programs/{id}', [ProgramsController::class, 'update'])->name('dashboard.programs.update');
    Route::delete('/dashboard/resource/programs/{id}', [ProgramsController::class, 'destroy'])->name('dashboard.programs.destroy');
    
    
    Route::get('/dashboard/resource/timeline', [TimelineController::class, 'index'])->name('dashboard.timeline');
});
