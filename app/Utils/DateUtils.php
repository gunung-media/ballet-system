<?php

namespace App\Utils;

use Carbon\Carbon;

class DateUtils
{
    static function format(string $date, bool $withTime = false): string
    {
        return Carbon::parse($date)->format('d F Y' . ($withTime ? ' H:i' : ''));
    }
}
