<?php

namespace Database\Factories;

use App\Models\Endereco;
use Illuminate\Database\Eloquent\Factories\Factory;

class EnderecoFactory extends Factory
{
    protected $model = Endereco::class;

    public function definition()
    {
        return [
            'cep' => $this->faker->postcode,
            'rua' => $this->faker->streetAddress,
        ];
    }
}
