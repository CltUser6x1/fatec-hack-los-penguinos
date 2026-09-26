<?php

namespace App\Http\Controllers;

use App\Models\Aviso;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class MuralController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $dados = $request->validate([
            'titulo' => ['required', 'string', 'max:120'],
            'conteudo' => ['required', 'string', 'max:2000'],
        ]);

        $request->user()->avisos()->create($dados);

        return redirect()->to(route('faq').'#mural')->with('status', 'Aviso publicado no mural.');
    }

    public function destroy(Request $request, Aviso $aviso): RedirectResponse
    {
        abort_unless($aviso->user_id === $request->user()->id, 403);

        $aviso->delete();

        return redirect()->to(route('faq').'#mural')->with('status', 'Aviso removido.');
    }
}
