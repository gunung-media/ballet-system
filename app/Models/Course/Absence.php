<?php

namespace App\Models\Course;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Absence extends BaseModel
{
    protected $fillable = [
        'date',
        'class_schedule_id',
        'teacher_id'
    ];

    public function schedule(): BelongsTo
    {
        return $this->belongsTo(ClassSchedule::class);
    }

    public function teacher(): BelongsTo
    {
        return $this->belongsTo(Teacher::class);
    }

    public function students(): HasMany
    {
        return $this->hasMany(AbsenceStudent::class);
    }
}
