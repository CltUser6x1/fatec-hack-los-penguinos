<?php

use App\Models\User;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('faq:admin {email} {--remover : Tira a permissão em vez de dar}', function (string $email) {
    $usuario = User::where('email', $email)->first();

    if (! $usuario) {
        $this->error("Nenhum usuário com o e-mail {$email}. Cadastre a conta pelo site primeiro.");

        return 1;
    }

    $usuario->is_admin = ! $this->option('remover');
    $usuario->save();

    $this->info($usuario->is_admin
        ? "{$usuario->name} agora pode editar o FAQ."
        : "{$usuario->name} não pode mais editar o FAQ.");

    return 0;
})->purpose('Dá (ou tira) a permissão de editar o FAQ para um usuário');
