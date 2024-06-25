<?php

namespace App\Models\Course;

use App\Enums\DayEnum;
use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ClassSchedule extends BaseModel
{
    protected $fillable = [
        'class_id',
        'day',
        'time',
        'duration'
    ];

    protected function casts(): array
    {
        return [
            'day' => DayEnum::class
        ];
    }

    public function class(): BelongsTo
    {
        return $this->belongsTo(ClassModel::class, 'class_id');
    }
}
