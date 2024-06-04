<?php

namespace App\Enums;

enum TeacherStatus: string
{
    case Active = 'Active';
    case Resign = 'Resign';
    case Vacation = 'Vacation';

    public function color(): string
    {
        return match ($this) {
            self::Active => 'success',
            self::Resign => 'danger',
            self::Vacation => 'warning',
        };
    }
}
