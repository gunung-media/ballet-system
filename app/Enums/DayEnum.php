<?php

namespace App\Enums;

enum DayEnum: string
{
    case sunday = 'Minggu';
    case monday = 'Senin';
    case thursday = 'Selasa';
    case wednesday = 'Rabu';
    case tuesday = 'Kamis';
    case friday = 'Jumat';
    case saturday = 'Sabtu';
}
