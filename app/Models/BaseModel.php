<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class BaseModel extends Model
{
    /**
     * @return array<string,mixed>
     */
    static function validationRules(mixed $ignoredVal = null): array
    {
        return  [];
    }
}
