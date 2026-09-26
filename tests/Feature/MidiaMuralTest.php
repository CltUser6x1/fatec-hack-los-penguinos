<?php

namespace Tests\Feature;

use App\Models\Aviso;
use App\Models\Setor;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class MidiaMuralTest extends TestCase
{
    use RefreshDatabase;

    private Setor $setor;

    protected function setUp(): void
    {
        parent::setUp();

        $this->setor = Setor::create(['nome' => 'Notícias Principais', 'slug' => 'noticias-principais']);
    }

    public function test_aviso_com_imagem_salva_o_arquivo(): void
    {
        Storage::fake('public');

        $this->actingAs(User::factory()->create())->post('/mural', [
            'setor_id' => $this->setor->id,
            'titulo' => 'Feira de profissões',
            'conteudo' => 'Veja o cartaz.',
            'imagem' => UploadedFile::fake()->image('cartaz.png', 800, 600),
        ])->assertSessionHasNoErrors();

        $aviso = Aviso::first();
        Storage::disk('public')->assertExists($aviso->imagem);
        $this->get('/')->assertSee($aviso->imagemUrl(), false);
        $this->get($aviso->imagemUrl())->assertOk()->assertHeader('Content-Type', 'image/png');
    }

    public function test_arquivo_que_nao_e_imagem_e_recusado(): void
    {
        Storage::fake('public');

        $this->actingAs(User::factory()->create())->post('/mural', [
            'setor_id' => $this->setor->id,
            'titulo' => 'Arquivo',
            'conteudo' => 'Texto',
            'imagem' => UploadedFile::fake()->create('virus.exe', 10),
        ])->assertSessionHasErrors('imagem');

        $this->assertDatabaseCount('avisos', 0);
    }

    public function test_video_do_youtube_vira_embed(): void
    {
        $this->actingAs(User::factory()->create())->post('/mural', [
            'setor_id' => $this->setor->id,
            'titulo' => 'Aula inaugural',
            'conteudo' => 'Assista.',
            'video_url' => 'https://youtu.be/dQw4w9WgXcQ',
        ])->assertSessionHasNoErrors();

        $this->get('/')->assertSee('https://www.youtube-nocookie.com/embed/dQw4w9WgXcQ', false);
    }

    public function test_link_que_nao_e_do_youtube_e_recusado(): void
    {
        $this->actingAs(User::factory()->create())->post('/mural', [
            'setor_id' => $this->setor->id,
            'titulo' => 'Vídeo',
            'conteudo' => 'Texto',
            'video_url' => 'https://exemplo.com/video',
        ])->assertSessionHasErrors('video_url');
    }

    public function test_reconhece_os_formatos_de_link_do_youtube(): void
    {
        foreach ([
            'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
            'https://youtube.com/watch?t=10&v=dQw4w9WgXcQ',
            'https://m.youtube.com/watch?v=dQw4w9WgXcQ',
            'https://youtu.be/dQw4w9WgXcQ?si=abc',
            'https://www.youtube.com/shorts/dQw4w9WgXcQ',
        ] as $url) {
            $this->assertSame('dQw4w9WgXcQ', Aviso::idDoYoutube($url), $url);
        }

        $this->assertNull(Aviso::idDoYoutube('https://www.youtube.com.golpe.com/watch?v=dQw4w9WgXcQ'));
    }

    public function test_excluir_aviso_apaga_a_imagem(): void
    {
        Storage::fake('public');
        $autor = User::factory()->create();

        $this->actingAs($autor)->post('/mural', [
            'setor_id' => $this->setor->id,
            'titulo' => 'Com imagem',
            'conteudo' => 'Texto',
            'imagem' => UploadedFile::fake()->image('foto.jpg'),
        ]);
        $aviso = Aviso::first();

        $this->actingAs($autor)->delete("/mural/{$aviso->id}");

        Storage::disk('public')->assertMissing($aviso->imagem);
    }
}
