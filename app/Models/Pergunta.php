<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pergunta extends Model
{
    protected $table = 'perguntas';

    protected $fillable = ['secao_id', 'pergunta', 'resposta', 'video_titulo', 'video_url', 'ordem'];

    public function secao(): BelongsTo
    {
        return $this->belongsTo(Secao::class);
    }
}
