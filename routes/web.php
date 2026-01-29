<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\InternController;
use Illuminate\Support\Facades\Auth;

// Default welcome page
Route::view('/', 'welcome');

// Redirect after login based on role
Route::get('/dashboard', function () {
    $user = Auth::user(); // 

    if ($user->role === 'admin') {
        return redirect()->route('admin.dashboard');
    } else {
        return redirect()->route('intern.dashboard');
    }
})->middleware(['auth'])->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

// Admin routes
Route::middleware(['auth', 'admin'])->group(function () {
    // Admin dashboard
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');

    // Manage tasks
    Route::get('/admin/tasks', [AdminController::class, 'tasks'])->name('admin.tasks');
    Route::get('/admin/tasks/create', [AdminController::class, 'createTask'])->name('admin.tasks.create');
    Route::post('/admin/tasks/store', [AdminController::class, 'storeTask'])->name('admin.tasks.store');
    Route::get('/admin/tasks/{task}/edit', [AdminController::class, 'editTask'])->name('admin.tasks.edit');
    Route::put('/admin/tasks/{task}', [AdminController::class, 'updateTask'])->name('admin.tasks.update');
    Route::delete('/admin/tasks/{task}', [AdminController::class, 'deleteTask'])->name('admin.tasks.delete');

    // Manage interns
    Route::get('/admin/interns', [AdminController::class, 'interns'])->name('admin.interns');
    Route::get('/admin/interns/create', [AdminController::class, 'createIntern'])->name('admin.interns.create');
    Route::post('/admin/interns/store', [AdminController::class, 'storeIntern'])->name('admin.interns.store');
    Route::get('/admin/interns/{user}/edit', [AdminController::class, 'editIntern'])->name('admin.interns.edit');
    Route::put('/admin/interns/{user}', [AdminController::class, 'updateIntern'])->name('admin.interns.update');
    Route::delete('/admin/interns/{user}', [AdminController::class, 'deleteIntern'])->name('admin.interns.delete');
});

// Intern routes
Route::middleware(['auth', 'intern'])->group(function () {
    // Intern dashboard
    Route::get('/intern/dashboard', [InternController::class, 'dashboard'])->name('intern.dashboard');

    // Mark task done
    Route::post('/intern/tasks/{task}/done', [InternController::class, 'markDone'])->name('intern.tasks.done');
});

require __DIR__.'/auth.php';
