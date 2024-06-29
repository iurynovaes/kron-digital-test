<?php

namespace Database\Seeders;

use App\Models\TipoEndereco;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TipoEnderecoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TipoEndereco::create(['tipo' => 'Cobrança']);
        TipoEndereco::create(['tipo' => 'Residencial']);
        TipoEndereco::create(['tipo' => 'Correspondência']);
    }
}
