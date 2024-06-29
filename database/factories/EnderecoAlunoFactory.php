<?php

namespace Database\Factories;

use App\Models\EnderecoAluno;
use Illuminate\Database\Eloquent\Factories\Factory;

class EnderecoAlunoFactory extends Factory
{
    protected $model = EnderecoAluno::class;

    public function definition()
    {
        return [
            'aluno_id' => \App\Models\Aluno::factory(),
            'endereco_id' => \App\Models\Endereco::factory(),
            'numero' => $this->faker->buildingNumber,
            'complemento' => $this->faker->text(7),
            'tipo_endereco_id' => $this->faker->numberBetween(1, 3),
        ];
    }
}
