<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;
use App\Http\Controllers\TasksController;

Route::middleware(['auth'])->group(function () {
    Route::get('/', [TasksController::class, 'index'])->name('home');
    Route::get('/dashboard', [TasksController::class, 'index'])->middleware(['auth'])->name('dashboard');
    Route::resource('tasks', TasksController::class);
});

require __DIR__.'/auth.php';
