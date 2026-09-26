<?php

namespace Tests\Feature;

use App\Models\Pergunta;
use App\Models\Secao;
use App\Models\User;
use Database\Seeders\FaqSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FaqAdminTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(FaqSeeder::class);
        $this->admin = User::factory()->create();
        $this->admin->forceFill(['is_admin' => true])->save();
    }

    public function test_visitante_e_usuario_comum_nao_editam_o_faq(): void
    {
        $this->get('/admin/faq')->assertRedirect('/login');

        $comum = User::factory()->create();
        $this->actingAs($comum)->get('/admin/faq')->assertForbidden();
        $this->actingAs($comum)->post('/admin/faq/secoes', ['titulo' => 'Invasão'])->assertForbidden();
        $this->assertDatabaseMissing('secoes', ['titulo' => 'Invasão']);
    }

    public function test_cadastro_nao_permite_virar_admin(): void
    {
        $this->post('/cadastro', [
            'name' => 'Espertinho',
            'email' => 'esperto@teste.com',
            'password' => 'senha-segura',
            'password_confirmation' => 'senha-segura',
            'is_admin' => 1,
        ]);

        $this->assertFalse(User::where('email', 'esperto@teste.com')->first()->is_admin);
    }

    public function test_admin_ve_o_painel_e_o_link_no_topo(): void
    {
        $this->actingAs($this->admin)->get('/')->assertSee('Editar FAQ');
        $this->actingAs($this->admin)->get('/admin/faq')->assertOk()->assertSee('Sobre a Fatec')->assertSee('O que é a Fatec?');
    }

    public function test_admin_cria_edita_e_remove_secao(): void
    {
        $this->actingAs($this->admin)->post('/admin/faq/secoes', ['titulo' => 'Biblioteca'])->assertRedirect('/admin/faq');
        $secao = Secao::where('titulo', 'Biblioteca')->firstOrFail();
        $this->assertSame(4, $secao->ordem);

        $this->actingAs($this->admin)->put("/admin/faq/secoes/{$secao->id}", ['titulo' => 'Biblioteca e Salas', 'ordem' => 0]);
        $this->assertDatabaseHas('secoes', ['id' => $secao->id, 'titulo' => 'Biblioteca e Salas', 'ordem' => 0]);

        $this->actingAs($this->admin)->delete("/admin/faq/secoes/{$secao->id}");
        $this->assertModelMissing($secao);
    }

    public function test_remover_secao_remove_as_perguntas_dela(): void
    {
        $secao = Secao::where('titulo', 'Vestibular')->first();

        $this->actingAs($this->admin)->delete("/admin/faq/secoes/{$secao->id}");

        $this->assertDatabaseMissing('perguntas', ['secao_id' => $secao->id]);
    }

    public function test_admin_adiciona_pergunta_que_aparece_no_faq(): void
    {
        $secao = Secao::where('titulo', 'Cursos')->first();

        $this->actingAs($this->admin)->get("/admin/faq/perguntas/nova?secao={$secao->id}")->assertOk();

        $this->actingAs($this->admin)->post('/admin/faq/perguntas', [
            'secao_id' => $secao->id,
            'pergunta' => 'Tem curso à noite?',
            'resposta' => 'Depende da unidade.',
            'video_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
            'video_titulo' => 'Cursos noturnos',
        ])->assertRedirect('/admin/faq');

        $this->assertSame(2, Pergunta::where('pergunta', 'Tem curso à noite?')->first()->ordem);
        $this->get('/')->assertSee('Tem curso à noite?')->assertSee('Cursos noturnos');
    }

    public function test_admin_edita_e_remove_pergunta(): void
    {
        $pergunta = Pergunta::where('pergunta', 'A Fatec é gratuita?')->first();

        $this->actingAs($this->admin)->get("/admin/faq/perguntas/{$pergunta->id}/editar")->assertOk()->assertSee('A Fatec é gratuita?');

        $this->actingAs($this->admin)->put("/admin/faq/perguntas/{$pergunta->id}", [
            'secao_id' => $pergunta->secao_id,
            'pergunta' => 'A Fatec cobra mensalidade?',
            'resposta' => 'Não, é gratuita.',
        ])->assertSessionHasNoErrors();

        $pergunta->refresh();
        $this->assertSame('A Fatec cobra mensalidade?', $pergunta->pergunta);
        $this->assertNull($pergunta->video_url);

        $this->actingAs($this->admin)->delete("/admin/faq/perguntas/{$pergunta->id}");
        $this->assertModelMissing($pergunta);
    }

    public function test_video_precisa_de_texto_do_botao(): void
    {
        $this->actingAs($this->admin)->post('/admin/faq/perguntas', [
            'secao_id' => Secao::first()->id,
            'pergunta' => 'Pergunta',
            'resposta' => 'Resposta',
            'video_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
        ])->assertSessionHasErrors('video_titulo');
    }

    public function test_comando_faq_admin_da_e_tira_permissao(): void
    {
        $usuario = User::factory()->create(['email' => 'coord@fatec.sp.gov.br']);

        $this->artisan('faq:admin', ['email' => 'coord@fatec.sp.gov.br'])->assertSuccessful();
        $this->assertTrue($usuario->fresh()->is_admin);

        $this->artisan('faq:admin', ['email' => 'coord@fatec.sp.gov.br', '--remover' => true])->assertSuccessful();
        $this->assertFalse($usuario->fresh()->is_admin);

        $this->artisan('faq:admin', ['email' => 'ninguem@teste.com'])->assertFailed();
    }
}
