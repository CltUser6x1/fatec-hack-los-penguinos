<?php

namespace Database\Seeders;

use App\Models\Setor;
use Illuminate\Database\Seeder;

class SetorSeeder extends Seeder
{
    /**
     * Cria os setores do mural. Pode rodar mais de uma vez sem duplicar.
     */
    public function run(): void
    {
        $setores = [
            'noticias-principais' => 'Notícias Principais',
            'cursos' => 'Cursos',
            'eventos' => 'Eventos',
            'estagios-e-vagas' => 'Estágios e Vagas',
        ];

        $ordem = 0;

        foreach ($setores as $slug => $nome) {
            Setor::updateOrCreate(['slug' => $slug], ['nome' => $nome, 'ordem' => $ordem++]);
        }
    }
}
