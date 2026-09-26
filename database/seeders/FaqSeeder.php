<?php

namespace Database\Seeders;

use App\Models\Secao;
use Illuminate\Database\Seeder;

class FaqSeeder extends Seeder
{
    /**
     * Popula o FAQ com as seções e perguntas iniciais sobre a Fatec.
     */
    public function run(): void
    {
        foreach ($this->conteudo() as $ordemSecao => $secao) {
            $registro = Secao::create([
                'titulo' => $secao['titulo'],
                'ordem' => $ordemSecao,
            ]);

            foreach ($secao['perguntas'] as $ordemPergunta => $pergunta) {
                $registro->perguntas()->create([
                    ...$pergunta,
                    'video_url' => $this->buscaYoutube($pergunta['video_titulo']),
                    'ordem' => $ordemPergunta,
                ]);
            }
        }
    }

    /**
     * Link de busca no YouTube, para não depender de um vídeo específico que pode sair do ar.
     */
    private function buscaYoutube(string $termo): string
    {
        return 'https://www.youtube.com/results?search_query='.urlencode($termo);
    }

    private function conteudo(): array
    {
        return [
            [
                'titulo' => 'Sobre a Fatec',
                'perguntas' => [
                    [
                        'pergunta' => 'O que é a Fatec?',
                        'resposta' => 'A Fatec (Faculdade de Tecnologia do Estado de São Paulo) é uma instituição pública de ensino superior mantida pelo Centro Paula Souza, autarquia do Governo do Estado de São Paulo. Ela oferece cursos superiores de tecnologia voltados ao mercado de trabalho.',
                        'video_titulo' => 'O que é a Fatec Centro Paula Souza',
                    ],
                    [
                        'pergunta' => 'A Fatec é gratuita?',
                        'resposta' => 'Sim. Por ser uma faculdade pública estadual, os cursos da Fatec não cobram mensalidade.',
                        'video_titulo' => 'Fatec faculdade pública e gratuita',
                    ],
                    [
                        'pergunta' => 'O que é o Centro Paula Souza?',
                        'resposta' => 'O Centro Paula Souza (CPS) é a autarquia do Governo do Estado de São Paulo que administra as Escolas Técnicas (Etecs) e as Faculdades de Tecnologia (Fatecs).',
                        'video_titulo' => 'Centro Paula Souza Etecs e Fatecs',
                    ],
                ],
            ],
            [
                'titulo' => 'Vestibular',
                'perguntas' => [
                    [
                        'pergunta' => 'Como faço para entrar na Fatec?',
                        'resposta' => 'O ingresso é feito pelo Vestibular Fatec, que acontece a cada semestre. As inscrições, o manual do candidato e as datas ficam no site oficial vestibularfatec.com.br.',
                        'video_titulo' => 'Vestibular Fatec como funciona',
                    ],
                    [
                        'pergunta' => 'Quando abrem as inscrições?',
                        'resposta' => 'O vestibular é semestral, então as inscrições abrem duas vezes por ano. Acompanhe o calendário no site do Vestibular Fatec para não perder o prazo.',
                        'video_titulo' => 'Inscrições Vestibular Fatec',
                    ],
                ],
            ],
            [
                'titulo' => 'Cursos',
                'perguntas' => [
                    [
                        'pergunta' => 'Quanto tempo dura um curso na Fatec?',
                        'resposta' => 'Os cursos superiores de tecnologia costumam durar três anos (seis semestres). A duração exata de cada curso está na página da unidade.',
                        'video_titulo' => 'Cursos superiores de tecnologia Fatec',
                    ],
                    [
                        'pergunta' => 'O diploma de tecnólogo é de nível superior?',
                        'resposta' => 'Sim. O tecnólogo é um curso de graduação reconhecido pelo MEC e permite seguir para especializações, mestrado e doutorado.',
                        'video_titulo' => 'Curso de tecnólogo é graduação',
                    ],
                ],
            ],
            [
                'titulo' => 'Vida acadêmica',
                'perguntas' => [
                    [
                        'pergunta' => 'Onde consulto minhas notas e faltas?',
                        'resposta' => 'Notas, faltas e o histórico ficam no SIGA, o sistema acadêmico usado pelas Fatecs. O acesso é feito com o seu RA e senha.',
                        'video_titulo' => 'Como acessar o SIGA Fatec',
                    ],
                    [
                        'pergunta' => 'O estágio é obrigatório?',
                        'resposta' => 'Depende do curso. Consulte o projeto pedagógico do seu curso ou a coordenação para saber se há estágio obrigatório e quantas horas são exigidas.',
                        'video_titulo' => 'Estágio na Fatec',
                    ],
                ],
            ],
        ];
    }
}
