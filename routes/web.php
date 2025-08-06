<?php

use App\Http\Controllers\ExamController;
use App\Http\Controllers\ExamParticipantController;
use App\Http\Controllers\ExamTakeController;
use App\Http\Controllers\SupervisorController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/health-check', function () {
    return response()->json([
        'status' => 'ok',
        'timestamp' => now()->toISOString(),
    ]);
})->name('health-check');

Route::get('/', function () {
    return Inertia::render('welcome');
})->name('home');

// Participant routes (no auth required)
Route::controller(ExamParticipantController::class)->group(function () {
    Route::get('/participant/login', 'index')->name('participant.login');
    Route::post('/participant/login', 'store')->name('participant.store');
});

// Exam taking routes (session-based auth)
Route::controller(ExamTakeController::class)->group(function () {
    Route::get('/exam', 'index')->name('exam.take');
    Route::post('/exam/answer', 'store')->name('exam.answer');
    Route::post('/exam/complete', 'update')->name('exam.complete');
    Route::get('/exam/completed', 'show')->name('exam.completed');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', function () {
        return Inertia::render('dashboard');
    })->name('dashboard');

    // Administrator routes
    Route::prefix('admin')->group(function () {
        Route::resource('exams', ExamController::class);
        // Additional admin routes will be added here
    });

    // Supervisor routes
    Route::prefix('supervisor')->group(function () {
        Route::get('/', [SupervisorController::class, 'index'])->name('supervisor.dashboard');
        Route::get('/room/{room}', [SupervisorController::class, 'show'])->name('supervisor.room');
        Route::post('/token', [SupervisorController::class, 'store'])->name('supervisor.token');
        Route::patch('/participant/{participant}', [SupervisorController::class, 'update'])->name('supervisor.attendance');
        Route::get('/report/{room}', [SupervisorController::class, 'edit'])->name('supervisor.report');
        Route::post('/report/{room}', [SupervisorController::class, 'destroy'])->name('supervisor.report.store');
    });
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
