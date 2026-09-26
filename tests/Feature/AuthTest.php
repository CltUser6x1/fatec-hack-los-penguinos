<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_telas_de_login_e_cadastro_abrem(): void
    {
        $this->get('/login')->assertOk()->assertSee('Entrar');
        $this->get('/cadastro')->assertOk()->assertSee('Criar conta');
    }

    public function test_pessoa_consegue_se_cadastrar(): void
    {
        $this->post('/cadastro', [
            'name' => 'Aluna Teste',
            'email' => 'aluna@fatec.sp.gov.br',
            'password' => 'senha-segura',
            'password_confirmation' => 'senha-segura',
        ])->assertRedirect('/');

        $this->assertAuthenticated();
        $this->assertDatabaseHas('users', ['email' => 'aluna@fatec.sp.gov.br']);
    }

    public function test_login_com_senha_certa_entra(): void
    {
        $usuario = User::factory()->create(['password' => 'senha-segura']);

        $this->post('/login', ['email' => $usuario->email, 'password' => 'senha-segura'])
            ->assertRedirect('/');

        $this->assertAuthenticatedAs($usuario);
    }

    public function test_login_com_senha_errada_mostra_erro(): void
    {
        $usuario = User::factory()->create(['password' => 'senha-segura']);

        $this->from('/login')
            ->post('/login', ['email' => $usuario->email, 'password' => 'errada'])
            ->assertRedirect('/login')
            ->assertSessionHasErrors('email');

        $this->assertGuest();
    }

    public function test_logout_encerra_a_sessao(): void
    {
        $this->actingAs(User::factory()->create())
            ->post('/logout')
            ->assertRedirect('/');

        $this->assertGuest();
    }
}
