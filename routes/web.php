<?php

use App\Http\Controllers\FaqController;
use Illuminate\Support\Facades\Route;

Route::get('/', [FaqController::class, 'index'])->name('faq');
