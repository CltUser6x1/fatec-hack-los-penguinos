<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Liga cada aviso a um setor. Avisos antigos ficam sem setor e aparecem em "Outros avisos".
     */
    public function up(): void
    {
        Schema::table('avisos', function (Blueprint $table) {
            $table->foreignId('setor_id')->nullable()->after('user_id')->constrained('setores')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('avisos', function (Blueprint $table) {
            $table->dropConstrainedForeignId('setor_id');
        });
    }
};
