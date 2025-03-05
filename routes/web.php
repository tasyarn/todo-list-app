<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TodolistController;

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

//user
Route::middleware(['auth','userMiddleware'])->group(function(){
    Route::get('dashboard',[UserController::class, 'index'])->name('dashboard');
    Route::post('/user/todolist', [TodolistController::class, 'store'])->name('user.todo.store');
    Route::get('/user/todolist/{id}/edit', [TodolistController::class, 'edit'])->name('user.todo.edit'); // Form edit todolist
    Route::put('/user/todolist/{id}', [TodolistController::class, 'update'])->name('user.todo.update'); // Update todolist
});

// ADMIN ROUTE (Admin bisa CRUD semua tugas)
Route::middleware(['auth', 'adminMiddleware'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.index');
    Route::post('/admin/todolist', [TodolistController::class, 'store'])->name('todo.store');
    Route::get('/admin/todolist/{id}/edit', [TodolistController::class, 'edit'])->name('todo.edit'); // Form edit todolist
    Route::put('/admin/todolist/{id}', [TodolistController::class, 'update'])->name('todo.update'); // Update todolist
    Route::delete('/admin/todolist/{id}', [TodolistController::class, 'destroy'])->name('todo.destroy'); // Hapus todolist
});

