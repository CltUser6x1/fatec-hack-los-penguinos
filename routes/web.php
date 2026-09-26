<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\MuralController;
use Illuminate\Support\Facades\Route;

Route::get('/', [FaqController::class, 'index'])->name('faq');
Route::get('/mural/{aviso}/imagem', [MuralController::class, 'imagem'])->name('mural.imagem');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'mostrarLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/cadastro', [AuthController::class, 'mostrarCadastro'])->name('register');
    Route::post('/cadastro', [AuthController::class, 'cadastrar']);
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::post('/mural', [MuralController::class, 'store'])->name('mural.store');
    Route::delete('/mural/{aviso}', [MuralController::class, 'destroy'])->name('mural.destroy');
});
