<?php

namespace App\Models\Course;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class ClassModel extends Model
{
    public function schedules(): HasMany
    {
        return $this->hasMany(ClassSchedule::class);
    }
}
