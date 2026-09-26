<?php

use App\Http\Controllers\Admin\FaqAdminController;
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

Route::middleware(['auth', 'admin'])->prefix('admin/faq')->name('admin.faq.')->group(function () {
    Route::get('/', [FaqAdminController::class, 'index'])->name('index');

    Route::post('/secoes', [FaqAdminController::class, 'storeSecao'])->name('secoes.store');
    Route::put('/secoes/{secao}', [FaqAdminController::class, 'updateSecao'])->name('secoes.update');
    Route::delete('/secoes/{secao}', [FaqAdminController::class, 'destroySecao'])->name('secoes.destroy');

    Route::get('/perguntas/nova', [FaqAdminController::class, 'createPergunta'])->name('perguntas.create');
    Route::post('/perguntas', [FaqAdminController::class, 'storePergunta'])->name('perguntas.store');
    Route::get('/perguntas/{pergunta}/editar', [FaqAdminController::class, 'editPergunta'])->name('perguntas.edit');
    Route::put('/perguntas/{pergunta}', [FaqAdminController::class, 'updatePergunta'])->name('perguntas.update');
    Route::delete('/perguntas/{pergunta}', [FaqAdminController::class, 'destroyPergunta'])->name('perguntas.destroy');
});
