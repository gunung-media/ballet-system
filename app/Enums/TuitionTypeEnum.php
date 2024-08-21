<?php

namespace App\Enums;

enum TuitionTypeEnum: string
{
    case trial = 'Biaya Trial';
    case registration = 'Biaya Pendaftaran';
    case spp = 'Iuran Bulanan(SPP)';
    case denda = 'Denda';
    case kelas = 'Biaya Kelas Insidentil';
    case sewa = 'Biaya Sewa Studio';
}
