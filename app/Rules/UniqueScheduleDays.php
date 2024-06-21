<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class UniqueScheduleDays implements Rule
{
    public function passes($attribute, $value)
    {
        $days = array_column($value, 'day');
        return count($days) === count(array_unique($days));
    }

    public function message()
    {
        return 'The schedule days must be distinct.';
    }
}
