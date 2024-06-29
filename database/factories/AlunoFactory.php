<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Aluno>
 */
class AlunoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nome_completo' => $this->faker->name,
            'nome_pai' => $this->faker->name,
            'nome_mae' => $this->faker->name,
            'data_nascimento' => $this->faker->date(),
            'serie_id' => \App\Models\Serie::factory(),
            'data_nascimento' => $this->faker->date(),
        ];
    }
}
