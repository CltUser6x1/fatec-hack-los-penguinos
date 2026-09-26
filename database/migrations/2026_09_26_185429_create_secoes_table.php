<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Cria a tabela das seções (listas) do FAQ.
     */
    public function up(): void
    {
        Schema::create('secoes', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');
            $table->unsignedInteger('ordem')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('secoes');
    }
};
