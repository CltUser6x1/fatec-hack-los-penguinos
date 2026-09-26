<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('titulo', 'Perguntas Frequentes') | Fatec Itaquera</title>
    <link rel="stylesheet" href="{{ asset('css/faq.css') }}">
</head>
<body>
    <header class="topo">
        <a href="{{ route('faq') }}" class="marca">
            <span class="marca-nome">Fatec</span>
            <span class="marca-unidade">Itaquera</span>
        </a>

        <div class="conta">
            @auth
                <span>Olá, {{ auth()->user()->name }}</span>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="link-botao">Sair</button>
                </form>
            @else
                <a href="{{ route('login') }}">Entrar</a>
                <a href="{{ route('register') }}" class="botao">Cadastrar</a>
            @endauth
        </div>
    </header>

    <nav class="menu">
        <div class="menu-links">
            <a href="{{ route('faq') }}">Perguntas frequentes</a>
            <a href="{{ route('faq') }}#mural">Mural</a>
        </div>
        @yield('menu-extra')
    </nav>

    @yield('conteudo')

    <footer class="rodape">
        Projeto Los Penguinos · 1º Hackathon Fatec Itaquera
    </footer>

    @stack('scripts')
</body>
</html>
