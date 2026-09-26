<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\FaqController;
use Illuminate\Support\Facades\Route;

Route::get('/', [FaqController::class, 'index'])->name('faq');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'mostrarLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/cadastro', [AuthController::class, 'mostrarCadastro'])->name('register');
    Route::post('/cadastro', [AuthController::class, 'cadastrar']);
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');
