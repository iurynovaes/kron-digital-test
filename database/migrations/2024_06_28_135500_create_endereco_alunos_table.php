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
        Schema::create('endereco_alunos', function (Blueprint $table) {
            $table->foreignId('endereco_id')->references('id')->on('enderecos')->onDelete('restrict');
            $table->foreignId('tipo_endereco_id')->references('id')->on('tipo_enderecos')->onDelete('restrict');
            $table->foreignId('aluno_id')->references('id')->on('alunos')->onDelete('cascade');
            $table->string('numero', 10);
            $table->string('complemento', 20)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('endereco_alunos', function (Blueprint $table) {
            $table->dropForeign(['endereco_id']);
            $table->dropForeign(['aluno_id']);
            $table->dropForeign(['tipo_endereco_id']);
        });

        Schema::dropIfExists('endereco_alunos');
    }
};
