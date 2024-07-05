<?php

namespace App\Models;

use App\Enums\TuitionTypeEnum;
use App\Models\Course\Student;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class TuitionTransaction extends BaseModel
{
    protected $fillable = [
        'student_id',
        'student_name',
        'for_month',
        'amount',
        'note',
        'tuition_type',
    ];

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    protected function casts(): array
    {
        return [
            'tuition_type' => TuitionTypeEnum::class
        ];
    }
}
