<?php

namespace App\Utils;

class EnumUtils
{
    static function toArray(String $enum): array
    {
        return collect($enum::cases())->map(fn ($e) => $e->value)->toArray();
    }
}
