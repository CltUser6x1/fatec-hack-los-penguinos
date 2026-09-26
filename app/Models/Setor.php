<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Setor extends Model
{
    protected $table = 'setores';

    protected $fillable = ['nome', 'slug', 'ordem'];

    public function avisos(): HasMany
    {
        return $this->hasMany(Aviso::class)->latest();
    }
}
