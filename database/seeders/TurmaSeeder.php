<?php

namespace Database\Seeders;

use App\Enums\Turno;
use Illuminate\Database\Seeder;
use App\Models\Serie;
use App\Models\Turma;
use Faker\Factory as Faker;

class TurmaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('pt_BR');

        $series = Serie::all();
        $turnos = array_keys(Turno::toArray());

        foreach (range(1, 50) as $index) {
            Turma::create([
                'nome' => 'Turma ' . $index,
                'vagas' => $faker->randomNumber(),
                'ano_letivo' => $faker->date('Y'),
                'serie_id' => $faker->randomElement($series)->id,
                'turno' => $faker->randomElement($turnos),
            ]);
        }
    }
}
