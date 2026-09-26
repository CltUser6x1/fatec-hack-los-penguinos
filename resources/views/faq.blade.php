<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Perguntas Frequentes | Fatec Itaquera</title>
    <link rel="stylesheet" href="{{ asset('css/faq.css') }}">
</head>
<body>
    <header class="topo">
        <a href="{{ route('faq') }}" class="marca">
            <span class="marca-nome">Fatec</span>
            <span class="marca-unidade">Itaquera</span>
        </a>
    </header>

    <nav class="menu">
        <span>Perguntas frequentes</span>
        <form class="busca" role="search" onsubmit="return false">
            <label for="busca" class="sr-only">Buscar no FAQ</label>
            <input id="busca" type="search" placeholder="Buscar no FAQ" autocomplete="off">
        </form>
    </nav>

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

    <footer class="rodape">
        Projeto Los Penguinos · 1º Hackathon Fatec Itaquera
    </footer>

    <script src="{{ asset('js/faq.js') }}"></script>
</body>
</html>
