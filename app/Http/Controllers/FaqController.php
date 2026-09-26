<?php

namespace App\Http\Controllers;

use App\Models\Aviso;
use App\Models\Secao;
use Illuminate\View\View;

class FaqController extends Controller
{
    public function index(): View
    {
        $secoes = Secao::with('perguntas')->orderBy('ordem')->get();
        $avisos = Aviso::with('autor')->latest()->take(30)->get();

        return view('faq', ['secoes' => $secoes, 'avisos' => $avisos]);
    }
}
