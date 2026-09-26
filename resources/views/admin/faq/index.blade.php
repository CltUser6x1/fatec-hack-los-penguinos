@extends('layouts.app')

@section('titulo', 'Editar FAQ')

@section('conteudo')
    <main class="conteudo admin">
        <p class="trilha"><a href="{{ route('faq') }}">Home</a> &gt; <strong>Editar FAQ</strong></p>

        <h2 class="titulo-secao">Editar FAQ</h2>

        @if (session('status'))
            <p class="aviso-status">{{ session('status') }}</p>
        @endif

        @if ($errors->any())
            <div class="erro-caixa">
                @foreach ($errors->all() as $erro)
                    <p class="erro">{{ $erro }}</p>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('admin.faq.secoes.store') }}" class="admin-linha admin-nova-secao">
            @csrf
            <label for="nova-secao" class="sr-only">Nome da nova seção</label>
            <input id="nova-secao" type="text" name="titulo" placeholder="Nome da nova seção (ex.: Biblioteca)" maxlength="120" required>
            <button type="submit" class="botao">Adicionar seção</button>
        </form>

        @forelse ($secoes as $secao)
            <section class="admin-secao">
                <form method="POST" action="{{ route('admin.faq.secoes.update', $secao) }}" class="admin-linha">
                    @csrf
                    @method('PUT')
                    <label class="sr-only" for="secao-{{ $secao->id }}">Nome da seção</label>
                    <input id="secao-{{ $secao->id }}" type="text" name="titulo" value="{{ $secao->titulo }}" maxlength="120" required class="admin-secao-titulo">
                    <label class="admin-ordem">
                        Ordem
                        <input type="number" name="ordem" value="{{ $secao->ordem }}" min="0" required>
                    </label>
                    <button type="submit" class="botao botao-secundario">Salvar</button>
                </form>

                <ul class="admin-perguntas">
                    @forelse ($secao->perguntas as $pergunta)
                        <li>
                            <span>{{ $pergunta->pergunta }}</span>
                            <span class="admin-acoes">
                                <a href="{{ route('admin.faq.perguntas.edit', $pergunta) }}">Editar</a>
                                <form method="POST" action="{{ route('admin.faq.perguntas.destroy', $pergunta) }}"
                                    onsubmit="return confirm('Remover a pergunta &quot;{{ addslashes($pergunta->pergunta) }}&quot;?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="link-botao">Excluir</button>
                                </form>
                            </span>
                        </li>
                    @empty
                        <li class="sem-resultado">Nenhuma pergunta nesta seção.</li>
                    @endforelse
                </ul>

                <div class="admin-rodape-secao">
                    <a href="{{ route('admin.faq.perguntas.create', ['secao' => $secao->id]) }}" class="botao">+ Nova pergunta</a>
                    <form method="POST" action="{{ route('admin.faq.secoes.destroy', $secao) }}"
                        onsubmit="return confirm('Remover a seção &quot;{{ addslashes($secao->titulo) }}&quot; e todas as suas perguntas?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="link-botao">Excluir seção</button>
                    </form>
                </div>
            </section>
        @empty
            <p class="sem-resultado">Nenhuma seção ainda. Crie a primeira acima.</p>
        @endforelse
    </main>
@endsection
