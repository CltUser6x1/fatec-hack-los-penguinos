<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Aviso extends Model
{
    protected $table = 'avisos';

    protected $fillable = ['titulo', 'conteudo', 'imagem', 'video_url'];

    public function autor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Extrai o ID de 11 caracteres de links do YouTube (watch, youtu.be, shorts, embed, live).
     */
    public static function idDoYoutube(?string $url): ?string
    {
        if (! $url) {
            return null;
        }

        $padrao = '~^https?://(?:www\.|m\.)?(?:youtube\.com/(?:watch\?(?:.*&)?v=|shorts/|embed/|live/)|youtu\.be/)([A-Za-z0-9_-]{11})~';

        return preg_match($padrao, $url, $partes) ? $partes[1] : null;
    }

    public function imagemUrl(): ?string
    {
        // Rota do próprio Laravel: funciona sem o storage:link e em localhost ou 127.0.0.1.
        return $this->imagem ? route('mural.imagem', $this, absolute: false) : null;
    }

    public function videoEmbedUrl(): ?string
    {
        $id = self::idDoYoutube($this->video_url);

        return $id ? "https://www.youtube-nocookie.com/embed/{$id}" : null;
    }
}
