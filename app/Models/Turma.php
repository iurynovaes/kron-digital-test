<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Turma extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'turno',
        'vagas',
        'ano_letivo',
        'serie_id',
    ];

    public function serie(): BelongsTo {
        return $this->belongsTo(Serie::class);
    }
    
    public function alunos(): HasManyThrough {
        return $this->hasManyThrough(Aluno::class, AlunoTurma::class, 'turma_id', 'id', 'id', 'aluno_id');
    }
}
