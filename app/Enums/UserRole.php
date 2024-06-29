<?php

namespace App\Enums;

enum UserRole: string
{
    case Secretaria = 'Secretaria';
    case Assistente = 'Assistente';
    case Cadastro = 'Cadastro';
}
