<?php

namespace App\Models;

use App\Enums\Series;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use stdClass;

class Aluno extends Model
{
    use HasFactory;

    protected $fillable = [
        'matricula',
        'nome_completo',
        'data_nascimento',
        'serie_id',
        'nome_pai',
        'nome_mae',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($aluno) {
            $maxId = self::max('id') + 1;
            $aluno->matricula = str_pad($maxId, 10, '0', STR_PAD_LEFT);
        });
    }

    public function serie(): BelongsTo {
        return $this->belongsTo(Serie::class);
    }

    public function enderecos_aluno(): HasMany {
        return $this->hasMany(EnderecoAluno::class);
    }
    
    public function getSegmento(): string {

        switch ($this->serie_id) {

            case Series::G1:
            case Series::G2:
            case Series::G3:
                return 'Infantil';

            case Series::PRIMEIRO_ANO:
            case Series::SEGUNDO_ANO:
            case Series::TERCEIRO_ANO:
            case Series::QUARTO_ANO:
            case Series::QUINTO_ANO:
                return 'Anos iniciais';

            case Series::SEXTO_ANO:
            case Series::SETIMO_ANO:
            case Series::OITAVO_ANO:
            case Series::NONO_ANO:
                return 'Anos finais';

            default:
                return 'Ensino Médio';
        }
    }

    public function getEnderecoCompleto(): stdClass {
        
        $enderecoAluno = $this->enderecos_aluno()->first();

        $obj = new stdClass();
        $obj->cep = $enderecoAluno->endereco->cep;
        $obj->rua = $enderecoAluno->endereco->rua;
        $obj->numero = $enderecoAluno->numero;
        $obj->complemento = $enderecoAluno->complemento;
        $obj->tipo_endereco_id = $enderecoAluno->tipo_endereco_id;

        return $obj;
    }
}
