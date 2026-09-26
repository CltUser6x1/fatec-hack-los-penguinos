<?php

namespace App\Http\Controllers;

use App\Models\Aviso;
use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class MuralController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $dados = $request->validate([
            'titulo' => ['required', 'string', 'max:120'],
            'conteudo' => ['required', 'string', 'max:10000'],
            'imagem' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp,gif', 'max:4096'],
            'video_url' => [
                'nullable',
                'url',
                'max:255',
                function (string $campo, mixed $valor, Closure $falhar) {
                    if (! Aviso::idDoYoutube($valor)) {
                        $falhar('Use um link do YouTube, como https://www.youtube.com/watch?v=...');
                    }
                },
            ],
        ]);

        if ($request->hasFile('imagem')) {
            $dados['imagem'] = $request->file('imagem')->store('avisos', 'public');
        }

        $request->user()->avisos()->create($dados);

        return redirect()->to(route('faq').'#mural')->with('status', 'Aviso publicado no mural.');
    }

    /**
     * Entrega a imagem do aviso direto do storage, sem depender do atalho public/storage.
     */
    public function imagem(Aviso $aviso): StreamedResponse
    {
        abort_unless($aviso->imagem && Storage::disk('public')->exists($aviso->imagem), 404);

        return Storage::disk('public')->response($aviso->imagem);
    }

    public function destroy(Request $request, Aviso $aviso): RedirectResponse
    {
        abort_unless($aviso->user_id === $request->user()->id, 403);

        if ($aviso->imagem) {
            Storage::disk('public')->delete($aviso->imagem);
        }

        $aviso->delete();

        return redirect()->to(route('faq').'#mural')->with('status', 'Aviso removido.');
    }
}
