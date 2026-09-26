<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Cria a tabela das perguntas de cada seção, com link opcional para o YouTube.
     */
    public function up(): void
    {
        Schema::create('perguntas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('secao_id')->constrained('secoes')->cascadeOnDelete();
            $table->string('pergunta');
            $table->text('resposta');
            $table->string('video_titulo')->nullable();
            $table->string('video_url')->nullable();
            $table->unsignedInteger('ordem')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('perguntas');
    }
};
