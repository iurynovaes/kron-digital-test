<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Serie extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'idade',
    ];

    public function alunos(): HasMany {
        return $this->hasMany(Aluno::class);
    }

    public function turmas(): HasMany {
        return $this->hasMany(Turma::class);
    }
}
