<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EnderecoAluno extends Model
{
    use HasFactory;

    protected $fillable = [
        'endereco_id',
        'aluno_id',
        'tipo_endereco_id',
        'numero',
        'complemento',
    ];

    public function endereco(): BelongsTo {
        return $this->belongsTo(Endereco::class);
    }

    public function tipo_endereco(): BelongsTo {
        return $this->belongsTo(TipoEndereco::class);
    }
    
    public function aluno(): BelongsTo {
        return $this->belongsTo(Aluno::class);
    }
}
