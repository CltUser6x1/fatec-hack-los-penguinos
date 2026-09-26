<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MuralTest extends TestCase
{
    use RefreshDatabase;

    public function test_visitante_ve_o_mural_mas_nao_o_formulario(): void
    {
        $autor = User::factory()->create(['name' => 'Coordenação']);
        $autor->avisos()->create(['titulo' => 'Semana de provas', 'conteudo' => 'As provas começam segunda.']);

        $this->get('/')
            ->assertOk()
            ->assertSee('Mural de avisos')
            ->assertSee('Semana de provas')
            ->assertSee('Coordenação')
            ->assertSee('para publicar no mural')
            ->assertDontSee('Publicar no mural');
    }

    public function test_visitante_nao_consegue_publicar(): void
    {
        $this->post('/mural', ['titulo' => 'Oi', 'conteudo' => 'Teste'])
            ->assertRedirect('/login');

        $this->assertDatabaseCount('avisos', 0);
    }

    public function test_usuario_logado_publica_aviso(): void
    {
        $usuario = User::factory()->create();

        $this->actingAs($usuario)
            ->post('/mural', ['titulo' => 'Palestra', 'conteudo' => 'Quinta às 19h no auditório.'])
            ->assertRedirect();

        $this->assertDatabaseHas('avisos', ['titulo' => 'Palestra', 'user_id' => $usuario->id]);
    }

    public function test_aviso_precisa_de_titulo_e_conteudo(): void
    {
        $this->actingAs(User::factory()->create())
            ->post('/mural', ['titulo' => '', 'conteudo' => ''])
            ->assertSessionHasErrors(['titulo', 'conteudo']);
    }

    public function test_so_o_autor_pode_excluir_o_aviso(): void
    {
        $autor = User::factory()->create();
        $outro = User::factory()->create();
        $aviso = $autor->avisos()->create(['titulo' => 'Aviso', 'conteudo' => 'Texto']);

        $this->actingAs($outro)->delete("/mural/{$aviso->id}")->assertForbidden();
        $this->assertModelExists($aviso);

        $this->actingAs($autor)->delete("/mural/{$aviso->id}")->assertRedirect();
        $this->assertModelMissing($aviso);
    }
}
