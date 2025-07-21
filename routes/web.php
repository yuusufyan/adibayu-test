<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ItemController;
use Spatie\Permission\Middleware\RoleMiddleware;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// routes/web.php
Route::middleware([
    'auth',
    RoleMiddleware::class . ':admin', // ⬅️ tambahin begini
])->group(function () {
    Route::resource('users', UserController::class);
});

// Items Router
Route::middleware([
    'auth',
    RoleMiddleware::class . ':admin', // ⬅️ tambahin begini
])->group(function () {
    Route::resource('items', ItemController::class);
    Route::get('/items/{id}/harga', function ($id) {
        return \App\Models\Items::findOrFail($id)->harga;
    });
});

// Sales Router
Route::middleware([
    'auth',
    RoleMiddleware::class . ':admin|cashier', // ⬅️ tambahin begini
])->group(function () {
    Route::resource('sales', SalesController::class);
});

require __DIR__ . '/auth.php';
