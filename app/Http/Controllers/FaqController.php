<?php

namespace App\Http\Controllers;

use App\Models\Aviso;
use App\Models\Secao;
use App\Models\Setor;
use Illuminate\View\View;

class FaqController extends Controller
{
    public function index(): View
    {
        $secoes = Secao::with('perguntas')->orderBy('ordem')->get();
        $setores = Setor::with('avisos.autor')->orderBy('ordem')->get();
        $avisosSemSetor = Aviso::with('autor')->whereNull('setor_id')->latest()->get();

        return view('faq', [
            'secoes' => $secoes,
            'setores' => $setores,
            'avisosSemSetor' => $avisosSemSetor,
        ]);
    }
}
