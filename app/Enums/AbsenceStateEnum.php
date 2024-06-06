<?php

namespace App\Enums;

enum AbsenceStateEnum: string
{
    case hadir = 'Hadir';
    case ijin = 'Ijin';
    case sakit = 'Sakit';
    case tidakHadir = 'Tidak Hadir';
}
