<?php

namespace Database\Factories;

use App\Models\Serie;
use Illuminate\Database\Eloquent\Factories\Factory;

class SerieFactory extends Factory
{
    protected $model = Serie::class;

    public function definition()
    {
        return [
            'nome' => $this->faker->randomElement([
                'G1', 'G2', 'G3', '1º ano', '2º ano', '3º ano', '4º ano', '5º ano', 
                '6º ano', '7º ano', '8º ano', '9º ano', '1º ano EM', '2º ano EM', '3º ano EM'
            ]),
            'idade' => $this->faker->randomNumber(2),
        ];
    }
}
