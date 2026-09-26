@extends('layouts.app')

@section('titulo', 'Entrar')

@section('conteudo')
    <main class="conteudo conteudo-estreito">
        <h2 class="titulo-secao">Entrar</h2>

        <form method="POST" action="{{ route('login') }}" class="formulario">
            @csrf

            <label for="email">E-mail</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="email">
            @error('email') <p class="erro">{{ $message }}</p> @enderror

            <label for="password">Senha</label>
            <input id="password" type="password" name="password" required autocomplete="current-password">
            @error('password') <p class="erro">{{ $message }}</p> @enderror

            <label class="lembrar">
                <input type="checkbox" name="remember"> Manter conectado
            </label>

            <button type="submit" class="botao">Entrar</button>
        </form>

        <p>Ainda não tem conta? <a href="{{ route('register') }}">Cadastre-se</a></p>
    </main>
@endsection
