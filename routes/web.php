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

// //user
//     Route::get('dashboard',[UserController::class, 'index'])->name('dashboard');
//     Route::post('/user/todolist', [TodolistController::class, 'store'])->name('user.todo.store');
//     Route::get('/user/todolist/{id}/edit', [TodolistController::class, 'edit'])->name('user.todo.edit');
//     Route::put('/user/todolist/{id}', [TodolistController::class, 'update'])->name('user.todo.update');


// //admin
// Route::middleware(['auth', 'adminMiddleware'])->group(function () {
//     Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.index');
//     Route::post('/admin/todolist', [TodolistController::class, 'store'])->name('todo.store');
//     Route::get('/admin/todolist/{id}/edit', [TodolistController::class, 'edit'])->name('todo.edit');
//     Route::put('/admin/todolist/{id}', [TodolistController::class, 'update'])->name('todo.update');
//     Route::delete('/admin/todolist/{id}', [TodolistController::class, 'destroy'])->name('todo.destroy');
// });

//user
Route::middleware(['auth', 'role_or_permission:user|create todolist|read todolist|update todolist'])->group(function () {
    Route::post('/user/todolist', [TodolistController::class, 'store'])->name('user.todo.store');
    Route::get('dashboard',[UserController::class, 'index'])->name('dashboard');
    Route::put('/user/todolist/{id}', [TodolistController::class, 'update'])->name('user.todo.update');
});

//admin
Route::middleware(['auth', 'role_or_permission:admin|create todolist|read todolist|update todolist|delete todolist'])->group(function () {
    Route::post('/admin/todolist', [TodolistController::class, 'store'])->name('todo.store');
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.index');
    Route::put('/admin/todolist/{id}', [TodolistController::class, 'update'])->name('todo.update');
    Route::delete('/admin/todolist/{id}', [TodolistController::class, 'destroy'])->name('todo.destroy');
});
