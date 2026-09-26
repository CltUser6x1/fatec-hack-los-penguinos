@extends('layouts.app')

@section('titulo', $pergunta->exists ? 'Editar pergunta' : 'Nova pergunta')

@section('conteudo')
    <main class="conteudo conteudo-estreito admin">
        <p class="trilha">
            <a href="{{ route('faq') }}">Home</a> &gt; <a href="{{ route('admin.faq.index') }}">Editar FAQ</a> &gt;
            <strong>{{ $pergunta->exists ? 'Editar pergunta' : 'Nova pergunta' }}</strong>
        </p>

        <h2 class="titulo-secao">{{ $pergunta->exists ? 'Editar pergunta' : 'Nova pergunta' }}</h2>

        <form method="POST" class="formulario"
            action="{{ $pergunta->exists ? route('admin.faq.perguntas.update', $pergunta) : route('admin.faq.perguntas.store') }}">
            @csrf
            @if ($pergunta->exists)
                @method('PUT')
            @endif

            <label for="secao_id">Seção</label>
            <select id="secao_id" name="secao_id" required>
                @foreach ($secoes as $secao)
                    <option value="{{ $secao->id }}" @selected(old('secao_id', $pergunta->secao_id) == $secao->id)>{{ $secao->titulo }}</option>
                @endforeach
            </select>
            @error('secao_id') <p class="erro">{{ $message }}</p> @enderror

            <label for="pergunta">Pergunta</label>
            <input id="pergunta" type="text" name="pergunta" value="{{ old('pergunta', $pergunta->pergunta) }}" maxlength="255" required>
            @error('pergunta') <p class="erro">{{ $message }}</p> @enderror

            <label for="resposta">Resposta</label>
            <textarea id="resposta" name="resposta" rows="6" maxlength="10000" required>{{ old('resposta', $pergunta->resposta) }}</textarea>
            @error('resposta') <p class="erro">{{ $message }}</p> @enderror

            <label for="video_url">Link do vídeo (opcional)</label>
            <input id="video_url" type="url" name="video_url" value="{{ old('video_url', $pergunta->video_url) }}" placeholder="https://www.youtube.com/...">
            @error('video_url') <p class="erro">{{ $message }}</p> @enderror

            <label for="video_titulo">Texto do botão do vídeo</label>
            <input id="video_titulo" type="text" name="video_titulo" value="{{ old('video_titulo', $pergunta->video_titulo) }}" maxlength="120" placeholder="Ex.: Como funciona o vestibular">
            @error('video_titulo') <p class="erro">{{ $message }}</p> @enderror

            <label for="ordem">Ordem na seção (opcional)</label>
            <input id="ordem" type="number" name="ordem" value="{{ old('ordem', $pergunta->ordem) }}" min="0">
            @error('ordem') <p class="erro">{{ $message }}</p> @enderror

            <button type="submit" class="botao">{{ $pergunta->exists ? 'Salvar alterações' : 'Adicionar pergunta' }}</button>
        </form>

        <p><a href="{{ route('admin.faq.index') }}">Voltar sem salvar</a></p>
    </main>
@endsection
