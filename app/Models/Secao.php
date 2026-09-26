<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Secao extends Model
{
    protected $table = 'secoes';

    protected $fillable = ['titulo', 'ordem'];

    public function perguntas(): HasMany
    {
        return $this->hasMany(Pergunta::class)->orderBy('ordem');
    }
}
