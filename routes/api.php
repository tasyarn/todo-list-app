<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\TodolistController;

// api public
Route::post('/register', [ApiController::class, 'register']);
Route::post('/login', [ApiController::class, 'login']);
Route::middleware('auth:api')->post('/logout', [ApiController::class, 'logout']);

// user
Route::middleware(['jwt.auth', 'role_or_permission:user|create todolist|read todolist|update todolist'])->group(function () {
    Route::get('/user/dashboard', [TodolistController::class, 'index']);
    Route::post('/user/todolist', [TodolistController::class, 'storeAPI']);
    Route::put('/user/todolist/{id}', [TodolistController::class, 'updateAPI']);
});

// admin
Route::middleware(['jwt.auth', 'role_or_permission:admin|create todolist|read todolist|update todolist|delete todolist'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index']);
    Route::post('/admin/todolist', [TodolistController::class, 'storeAPI']);
    Route::put('/admin/todolist/{id}', [TodolistController::class, 'updateAPI']);
    Route::delete('/admin/todolist/{id}', [TodolistController::class, 'destroyAPI']);
});
