<?php

use App\Http\Controllers\AnalysisHistoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ResumeAnalysisController;
use Illuminate\Support\Facades\Route;

Route::get('/', DashboardController::class)->name('dashboard');
Route::get('/analyses/create', [ResumeAnalysisController::class, 'create'])->name('analyses.create');
Route::post('/analyses', [ResumeAnalysisController::class, 'store'])
    ->middleware('throttle:5,1')
    ->name('analyses.store');
Route::get('/analyses/pending/{trackingId}', [ResumeAnalysisController::class, 'processing'])
    ->where('trackingId', '[0-9a-fA-F-]{36}')
    ->name('analyses.processing');
Route::get('/analyses/pending/{trackingId}/status', [ResumeAnalysisController::class, 'status'])
    ->middleware('throttle:120,1')
    ->where('trackingId', '[0-9a-fA-F-]{36}')
    ->name('analyses.status');
Route::get('/analyses/{analysis}', [ResumeAnalysisController::class, 'show'])
    ->whereNumber('analysis')
    ->name('analyses.show');
Route::get('/analyses', [AnalysisHistoryController::class, 'index'])->name('analyses.history');
