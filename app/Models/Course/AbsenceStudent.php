<?php

namespace App\Models\Course;

use App\Enums\AbsenceStateEnum;
use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AbsenceStudent extends BaseModel
{
    protected $fillable = [
        'absence_id',
        'student_id',
        'state',
    ];

    protected function casts(): array
    {
        return [
            'state' => AbsenceStateEnum::class
        ];
    }

    public function absence(): BelongsTo
    {
        return $this->belongsTo(Absence::class);
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }
}
