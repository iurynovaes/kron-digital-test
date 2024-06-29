<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Aluno;
use App\Models\Endereco;
use App\Models\EnderecoAluno;
use App\Models\Serie;
use App\Models\TipoEndereco;
use Faker\Factory as Faker;

class AlunoSeeder extends Seeder
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
        $tipoEnderecos = TipoEndereco::all();

        foreach (range(1, 50) as $index) {
            $aluno = Aluno::create([
                'nome_completo' => $faker->name,
                'nome_pai' => $faker->name,
                'nome_mae' => $faker->name,
                'data_nascimento' => $faker->date('Y-m-d', '2005-01-01'),
                'serie_id' => $faker->randomElement($series)->id,
            ]);

            $endereco = Endereco::create([
                'cep' => str_pad($aluno->id, 8, '0', STR_PAD_LEFT),
                'rua' => $faker->streetAddress,
            ]);

            EnderecoAluno::create([
                'aluno_id' => $aluno->id,
                'endereco_id' => $endereco->id,
                'tipo_endereco_id' => $faker->randomElement($tipoEnderecos)->id,
                'numero' => $faker->randomNumber(3),
                'complemento' => $faker->text(7),
            ]);
        }
    }
}
