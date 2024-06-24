<?php

namespace App\Models\Course;

use App\Models\BaseModel;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Absence extends BaseModel
{
    protected $fillable = [
        'date',
        'class_schedule_id',
        'teacher_id'
    ];

    protected $with = ['students'];
    protected $appends = ['created_at_formated'];

    public function schedule(): BelongsTo
    {
        return $this->belongsTo(ClassSchedule::class, 'class_schedule_id');
    }

    public function teacher(): BelongsTo
    {
        return $this->belongsTo(Teacher::class);
    }

    public function students(): HasMany
    {
        return $this->hasMany(AbsenceStudent::class);
    }

    public function createdAtFormated(): Attribute
    {
        return new Attribute(
            get: fn () => Carbon::parse($this->created_at)->format('j F Y')
        );
    }
}
