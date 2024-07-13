<?php

namespace App\Utils;

class IntegerUtils
{
    public static function toRupiah(int $number): string
    {
        return 'Rp. ' . number_format($number, 0, ',', '.');
    }
}
