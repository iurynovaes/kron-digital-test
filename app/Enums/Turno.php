<?php

namespace App\Enums;

class Turno
{
    const MANHA = 'manhã';
    const TARDE = 'tarde';
    const INTEGRAL = 'integral';

    public static function toArray(): array
    {
        return [
            self::MANHA => 'Manhã',
            self::TARDE => 'Tarde',
            self::INTEGRAL => 'Integral',
        ];
    }
}