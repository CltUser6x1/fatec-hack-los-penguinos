<?php

namespace Tests\Feature;

use Database\Seeders\FaqSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FaqTest extends TestCase
{
    use RefreshDatabase;

    public function test_pagina_do_faq_mostra_as_secoes_e_respostas(): void
    {
        $this->seed(FaqSeeder::class);

        $this->get('/')
            ->assertOk()
            ->assertSee('Sobre a Fatec')
            ->assertSee('O que é a Fatec?')
            ->assertSee('A Fatec (Faculdade de Tecnologia do Estado de São Paulo)')
            ->assertSee('https://www.youtube.com/results?search_query=', false);
    }

    public function test_pagina_do_faq_funciona_sem_perguntas(): void
    {
        $this->get('/')
            ->assertOk()
            ->assertSee('Nenhuma pergunta cadastrada ainda.');
    }
}
