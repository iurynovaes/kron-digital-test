<?php

namespace Database\Seeders;

use App\Models\Serie;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SerieSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Serie::create([
            'nome' => 'G1',
            'idade' => '3'
        ]);
        Serie::create([
            'nome' => 'G2',
            'idade' => '4'
        ]);
        Serie::create([
            'nome' => 'G3',
            'idade' => '5'
        ]);
        Serie::create([
            'nome' => '1º ANO',
            'idade' => '6'
        ]);
        Serie::create([
            'nome' => '2º ANO',
            'idade' => '7'
        ]);
        Serie::create([
            'nome' => '3º ANO',
            'idade' => '8'
        ]);
        Serie::create([
            'nome' => '4º ANO',
            'idade' => '9'
        ]);
        Serie::create([
            'nome' => '5º ANO',
            'idade' => '10'
        ]);
        Serie::create([
            'nome' => '6º ANO',
            'idade' => '11'
        ]);
        Serie::create([
            'nome' => '7º ANO',
            'idade' => '12'
        ]);
        Serie::create([
            'nome' => '8º ANO',
            'idade' => '13'
        ]);
        Serie::create([
            'nome' => '9º ANO',
            'idade' => '14'
        ]);
        Serie::create([
            'nome' => '1º ANO E.M.',
            'idade' => '15'
        ]);
        Serie::create([
            'nome' => '2º ANO E.M.',
            'idade' => '16'
        ]);
        Serie::create([
            'nome' => '3º ANO E.M.',
            'idade' => '17'
        ]);
    }
}
