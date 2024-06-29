<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AlunoTurma extends Model
{
    use HasFactory;

    protected $fillable = [
        'aluno_id',
        'turma_id',
    ];

    public function aluno(): BelongsTo {
        return $this->belongsTo(Aluno::class);
    }

    public function turma(): BelongsTo {
        return $this->belongsTo(Turma::class);
    }
}
