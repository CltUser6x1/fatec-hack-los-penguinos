<?php

namespace Tests\Feature;

use App\Models\Setor;
use App\Models\User;
use Database\Seeders\SetorSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SetorMuralTest extends TestCase
{
    use RefreshDatabase;

    public function test_seeder_cria_os_setores_sem_duplicar(): void
    {
        $this->seed(SetorSeeder::class);
        $this->seed(SetorSeeder::class);

        $this->assertDatabaseCount('setores', 4);
        $this->assertSame(
            ['Notícias Principais', 'Cursos', 'Eventos', 'Estágios e Vagas'],
            Setor::orderBy('ordem')->pluck('nome')->all(),
        );
    }

    public function test_mural_mostra_cada_aviso_no_seu_setor(): void
    {
        $this->seed(SetorSeeder::class);
        $cursos = Setor::where('slug', 'cursos')->first();
        User::factory()->create()->avisos()->create([
            'setor_id' => $cursos->id,
            'titulo' => 'Novo curso de IA',
            'conteudo' => 'Inscrições abertas.',
        ]);

        $this->get('/')
            ->assertOk()
            ->assertSeeInOrder(['Notícias Principais', 'Nenhum aviso neste setor ainda.', 'Cursos', 'Novo curso de IA', 'Eventos']);
    }

    public function test_aviso_precisa_de_um_setor_valido(): void
    {
        $this->actingAs(User::factory()->create())
            ->post('/mural', ['setor_id' => 999, 'titulo' => 'Oi', 'conteudo' => 'Texto'])
            ->assertSessionHasErrors('setor_id');

        $this->assertDatabaseCount('avisos', 0);
    }

    public function test_aviso_antigo_sem_setor_aparece_em_outros_avisos(): void
    {
        User::factory()->create()->avisos()->create(['titulo' => 'Aviso antigo', 'conteudo' => 'Texto']);

        $this->get('/')->assertSeeInOrder(['Outros avisos', 'Aviso antigo']);
    }
}
