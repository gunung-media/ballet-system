<?php

namespace App\Models\Course;

use App\Enums\DayEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class ClassSchedule extends Model
{

    public function casts(): array
    {
        return [
            'day' => DayEnum::class
        ];
    }

    public function class(): BelongsTo
    {
        return $this->belongsTo(ClassModel::class);
    }
}
