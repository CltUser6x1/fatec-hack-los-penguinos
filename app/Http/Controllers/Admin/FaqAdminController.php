<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pergunta;
use App\Models\Secao;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FaqAdminController extends Controller
{
    public function index(): View
    {
        $secoes = Secao::with('perguntas')->orderBy('ordem')->get();

        return view('admin.faq.index', ['secoes' => $secoes]);
    }

    public function storeSecao(Request $request): RedirectResponse
    {
        $dados = $request->validate(['titulo' => ['required', 'string', 'max:120']]);

        Secao::create([...$dados, 'ordem' => (Secao::max('ordem') ?? -1) + 1]);

        return $this->voltar('Seção criada.');
    }

    public function updateSecao(Request $request, Secao $secao): RedirectResponse
    {
        $secao->update($request->validate([
            'titulo' => ['required', 'string', 'max:120'],
            'ordem' => ['required', 'integer', 'min:0'],
        ]));

        return $this->voltar('Seção atualizada.');
    }

    public function destroySecao(Secao $secao): RedirectResponse
    {
        $secao->delete();

        return $this->voltar('Seção e suas perguntas removidas.');
    }

    public function createPergunta(Request $request): View
    {
        $pergunta = new Pergunta(['secao_id' => $request->integer('secao') ?: null]);

        return view('admin.faq.pergunta', ['pergunta' => $pergunta, 'secoes' => Secao::orderBy('ordem')->get()]);
    }

    public function storePergunta(Request $request): RedirectResponse
    {
        $dados = $this->validarPergunta($request);
        $dados['ordem'] ??= (Pergunta::where('secao_id', $dados['secao_id'])->max('ordem') ?? -1) + 1;

        Pergunta::create($dados);

        return $this->voltar('Pergunta adicionada.');
    }

    public function editPergunta(Pergunta $pergunta): View
    {
        return view('admin.faq.pergunta', ['pergunta' => $pergunta, 'secoes' => Secao::orderBy('ordem')->get()]);
    }

    public function updatePergunta(Request $request, Pergunta $pergunta): RedirectResponse
    {
        $dados = $this->validarPergunta($request);
        $dados['ordem'] ??= $pergunta->ordem;

        $pergunta->update($dados);

        return $this->voltar('Pergunta atualizada.');
    }

    public function destroyPergunta(Pergunta $pergunta): RedirectResponse
    {
        $pergunta->delete();

        return $this->voltar('Pergunta removida.');
    }

    private function validarPergunta(Request $request): array
    {
        return $request->validate([
            'secao_id' => ['required', 'exists:secoes,id'],
            'pergunta' => ['required', 'string', 'max:255'],
            'resposta' => ['required', 'string', 'max:10000'],
            'video_url' => ['nullable', 'url', 'max:255'],
            'video_titulo' => ['nullable', 'required_with:video_url', 'string', 'max:120'],
            'ordem' => ['nullable', 'integer', 'min:0'],
        ]);
    }

    private function voltar(string $mensagem): RedirectResponse
    {
        return redirect()->route('admin.faq.index')->with('status', $mensagem);
    }
}
