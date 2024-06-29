<?php

namespace App\Enums;

enum TipoEndereco: string
{
    case Cobranca = 1;
    case Residencial = 2;
    case Correspondencia = 3;
}