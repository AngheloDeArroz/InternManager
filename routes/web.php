<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\InternController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    if (Auth::user()->role === 'admin') {
        return redirect()->route('admin.dashboard');
    }
    if (Auth::user()->role === 'intern') {
        return redirect()->route('intern.dashboard');
    }
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
    
    // Tasks
    Route::get('/tasks', [AdminController::class, 'tasks'])->name('tasks');
    Route::get('/tasks/create', [AdminController::class, 'createTask'])->name('tasks.create');
    Route::post('/tasks', [AdminController::class, 'storeTask'])->name('tasks.store');
    Route::get('/tasks/{task}/edit', [AdminController::class, 'editTask'])->name('tasks.edit');
    Route::put('/tasks/{task}', [AdminController::class, 'updateTask'])->name('tasks.update');
    Route::delete('/tasks/{task}', [AdminController::class, 'deleteTask'])->name('tasks.delete');

    // Interns
    Route::get('/interns', [AdminController::class, 'interns'])->name('interns');
    Route::get('/interns/create', [AdminController::class, 'createIntern'])->name('interns.create');
    Route::post('/interns', [AdminController::class, 'storeIntern'])->name('interns.store');
    Route::get('/interns/{user}/edit', [AdminController::class, 'editIntern'])->name('interns.edit');
    Route::put('/interns/{user}', [AdminController::class, 'updateIntern'])->name('interns.update');
    Route::delete('/interns/{user}', [AdminController::class, 'deleteIntern'])->name('interns.delete');
});

Route::middleware(['auth', 'intern'])->prefix('intern')->name('intern.')->group(function () {
    Route::get('/dashboard', [InternController::class, 'dashboard'])->name('dashboard');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
