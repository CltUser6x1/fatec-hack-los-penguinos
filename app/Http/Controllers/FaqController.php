<?php

namespace App\Http\Controllers;

use App\Models\Secao;
use Illuminate\View\View;

class FaqController extends Controller
{
    public function index(): View
    {
        $secoes = Secao::with('perguntas')->orderBy('ordem')->get();

        return view('faq', ['secoes' => $secoes]);
    }
}
