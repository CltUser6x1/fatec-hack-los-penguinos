@extends('layouts.app')

@section('menu-extra')
    <form class="busca" role="search" onsubmit="return false">
        <label for="busca" class="sr-only">Buscar no FAQ</label>
        <input id="busca" type="search" placeholder="Buscar no FAQ" autocomplete="off">
    </form>
@endsection

@section('conteudo')
    <section class="banner">
        <h1>Tire suas dúvidas sobre a Fatec</h1>
    </section>

    <main class="conteudo">
        <p class="trilha"><a href="{{ route('faq') }}">Home</a> &gt; <strong>FAQ</strong></p>

        <h2 class="titulo-secao">Selecione o assunto desejado</h2>

        @forelse ($secoes as $secao)
            <details class="lista" data-secao>
                <summary>{{ $secao->titulo }}</summary>

                <ul class="perguntas">
                    @foreach ($secao->perguntas as $pergunta)
                        <li data-pergunta>
                            <details class="pergunta">
                                <summary>{{ $pergunta->pergunta }}</summary>
                                <p>{{ $pergunta->resposta }}</p>
                                @if ($pergunta->video_url)
                                    <a class="video" href="{{ $pergunta->video_url }}" target="_blank" rel="noopener">
                                        ▶ Vídeos no YouTube: {{ $pergunta->video_titulo }}
                                    </a>
                                @endif
                            </details>
                        </li>
                    @endforeach
                </ul>
            </details>
        @empty
            <p>Nenhuma pergunta cadastrada ainda.</p>
        @endforelse

        <p id="sem-resultado" class="sem-resultado" hidden>Nenhuma pergunta encontrada para essa busca.</p>

        <section id="mural" class="mural">
            <h2 class="titulo-secao">Mural de avisos</h2>

            @if (session('status'))
                <p class="aviso-status">{{ session('status') }}</p>
            @endif

            @auth
                <form method="POST" action="{{ route('mural.store') }}" class="formulario mural-form">
                    @csrf
                    <label for="titulo">Título</label>
                    <input id="titulo" type="text" name="titulo" value="{{ old('titulo') }}" maxlength="120" required>
                    @error('titulo') <p class="erro">{{ $message }}</p> @enderror

                    <label for="conteudo">Informação</label>
                    <textarea id="conteudo" name="conteudo" rows="4" maxlength="2000" required>{{ old('conteudo') }}</textarea>
                    @error('conteudo') <p class="erro">{{ $message }}</p> @enderror

                    <button type="submit" class="botao">Publicar no mural</button>
                </form>
            @else
                <p class="mural-convite">
                    <a href="{{ route('login') }}">Entre</a> ou <a href="{{ route('register') }}">cadastre-se</a> para publicar no mural.
                </p>
            @endauth

            <div class="mural-grade">
                @forelse ($avisos as $aviso)
                    <article class="recado">
                        <h3>{{ $aviso->titulo }}</h3>
                        <p>{{ $aviso->conteudo }}</p>
                        <footer>
                            <span>{{ $aviso->autor->name }} · {{ $aviso->created_at->format('d/m/Y H:i') }}</span>
                            @if (auth()->id() === $aviso->user_id)
                                <form method="POST" action="{{ route('mural.destroy', $aviso) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="link-botao">Excluir</button>
                                </form>
                            @endif
                        </footer>
                    </article>
                @empty
                    <p class="sem-resultado">Nenhum aviso no mural ainda.</p>
                @endforelse
            </div>
        </section>
    </main>
@endsection

@push('scripts')
    <script src="{{ asset('js/faq.js') }}"></script>
@endpush
