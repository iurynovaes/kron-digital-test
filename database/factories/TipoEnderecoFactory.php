<?php

namespace Database\Factories;

use App\Models\TipoEndereco;
use Illuminate\Database\Eloquent\Factories\Factory;

class TipoEnderecoFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = TipoEndereco::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'tipo' => $this->faker->randomElement(['Residencial', 'Comercial', 'Correspondência']),
        ];
    }
}