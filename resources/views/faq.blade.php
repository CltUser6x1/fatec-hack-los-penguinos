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
    </main>
@endsection

@push('scripts')
    <script src="{{ asset('js/faq.js') }}"></script>
@endpush
