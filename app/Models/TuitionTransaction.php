<?php

namespace App\Models;

use App\Models\Course\Student;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class TuitionTransaction extends BaseModel
{
    protected $fillable = [
        'student_id',
        'for_month',
        'amount',
        'note',
    ];

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }
}
