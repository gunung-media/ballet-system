<?php

namespace App\Utils;

use Carbon\Carbon;

class DateUtils
{
    static function format(string $date, bool $withTime = false, bool $removeDay = false): string
    {
        return Carbon::parse($date)->format($removeDay ? 'F Y' : 'd F Y' . ($withTime ? ' H:i' : ''));
    }
}
