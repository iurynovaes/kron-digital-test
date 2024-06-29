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
        Schema::create('aluno_turmas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('aluno_id')->references('id')->on('alunos')->onDelete('cascade');
            $table->foreignId('turma_id')->references('id')->on('turmas')->onDelete('cascade');
            $table->timestamps();

            $table->unique(['aluno_id', 'turma_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('aluno_turmas', function (Blueprint $table) {
            $table->dropForeign(['aluno_id']);
            $table->dropForeign(['turma_id']);
            $table->dropUnique(['aluno_id', 'turma_id']);
        });

        Schema::dropIfExists('aluno_turmas');
    }
};
