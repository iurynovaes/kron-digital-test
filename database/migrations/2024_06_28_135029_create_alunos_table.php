<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('alunos', function (Blueprint $table) {
            $table->id();
            $table->string('matricula', 10);
            $table->string('nome_completo', 50);
            $table->date('data_nascimento');
            $table->string('nome_pai', 50);
            $table->string('nome_mae', 50);
            $table->foreignId('serie_id')->references('id')->on('series')->onDelete('restrict');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('alunos', function (Blueprint $table) {
            $table->dropForeign(['serie_id']);
        });

        Schema::dropIfExists('alunos');
    }
};
