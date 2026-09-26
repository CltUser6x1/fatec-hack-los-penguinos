<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Permite anexar uma imagem e um vídeo do YouTube em cada aviso do mural.
     */
    public function up(): void
    {
        Schema::table('avisos', function (Blueprint $table) {
            $table->string('imagem')->nullable()->after('conteudo');
            $table->string('video_url')->nullable()->after('imagem');
        });
    }

    public function down(): void
    {
        Schema::table('avisos', function (Blueprint $table) {
            $table->dropColumn(['imagem', 'video_url']);
        });
    }
};
