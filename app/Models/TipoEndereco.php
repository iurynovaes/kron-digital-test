<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TipoEndereco extends Model
{
    use HasFactory;

    protected $fillable = [
        'tipo',
    ];

    public function enderecos_user(): HasMany {
        return $this->hasMany(EnderecoAluno::class);
    }
}
