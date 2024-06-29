<?php

namespace App\Services;

use App\Models\Aluno;
use App\Models\Endereco;
use App\Models\EnderecoAluno;

class EnderecoAlunoService
{
    private $aluno;
    private $data;

    public function __construct(Aluno $aluno, array $data) {
        $this->aluno = $aluno;
        $this->data = $data;
    }

    public function createEnderecoAluno(): EnderecoAluno {
        
        $endereco = Endereco::buscaEnderecoPorCEP($this->data['cep']);

        if (empty($endereco)) {
            $endereco = Endereco::create([
                'cep' => trim($this->data['cep']),
                'rua' => trim($this->data['rua'])
            ]);
        }

        return EnderecoAluno::create([
            'aluno_id' => $this->aluno->id,
            'endereco_id' => $endereco->id,
            'numero' => $this->data['numero'],
            'complemento' => $this->data['complemento'],
            'tipo_endereco_id' => $this->data['tipo_endereco_id'],
        ]);
    }
    
    public function updateEnderecoAluno(): EnderecoAluno {
        
        $endereco = Endereco::buscaEnderecoPorCEP($this->data['cep']);

        if (empty($endereco)) {
            $endereco = Endereco::create([
                'cep' => trim($this->data['cep']),
                'rua' => trim($this->data['rua'])
            ]);
        }

        EnderecoAluno::where('aluno_id', $this->aluno->id)->update([
            'endereco_id' => $endereco->id,
            'numero' => $this->data['numero'],
            'complemento' => $this->data['complemento'],
            'tipo_endereco_id' => $this->data['tipo_endereco_id'],
        ]);

        return EnderecoAluno::where('aluno_id', $this->aluno->id)->first();
    }
}