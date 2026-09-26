@extends('layouts.app')

@section('titulo', 'Cadastrar')

@section('conteudo')
    <main class="conteudo conteudo-estreito">
        <h2 class="titulo-secao">Criar conta</h2>

        <form method="POST" action="{{ route('register') }}" class="formulario">
            @csrf

            <label for="name">Nome</label>
            <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name">
            @error('name') <p class="erro">{{ $message }}</p> @enderror

            <label for="email">E-mail</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="email">
            @error('email') <p class="erro">{{ $message }}</p> @enderror

            <label for="password">Senha</label>
            <input id="password" type="password" name="password" required autocomplete="new-password">
            @error('password') <p class="erro">{{ $message }}</p> @enderror

            <label for="password_confirmation">Confirme a senha</label>
            <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password">

            <button type="submit" class="botao">Cadastrar</button>
        </form>

        <p>Já tem conta? <a href="{{ route('login') }}">Entrar</a></p>
    </main>
@endsection
