<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Enums\UserRole;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Secretaria',
            'email' => 'secretaria@test.com',
            'password' => Hash::make('123'),
            'role' => UserRole::Secretaria,
        ]);

        User::create([
            'name' => 'Assistente',
            'email' => 'assistente@test.com',
            'password' => Hash::make('123'),
            'role' => UserRole::Assistente,
        ]);

        User::create([
            'name' => 'Cadastro',
            'email' => 'cadastro@test.com',
            'password' => Hash::make('123'),
            'role' => UserRole::Cadastro,
        ]);
    }
}
