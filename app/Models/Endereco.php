<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Endereco extends Model
{
    use HasFactory;

    protected $fillable = [
        'cep',
        'rua',
    ];

    public function enderecos_aluno(): HasMany {
        return $this->hasMany(EnderecoAluno::class);
    }

    public static function buscaEnderecoPorCEP(string $cep): mixed {
        return Endereco::where('cep', $cep)->first();
    }
}
