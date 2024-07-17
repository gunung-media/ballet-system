<?php

namespace App\Models;

use App\Models\Course\Teacher;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EmployeeAbsence extends BaseModel
{
    protected $fillable = [
        'teacher_id',
        'date',
        'check_in',
        'check_out'
    ];

    public function teacher(): BelongsTo
    {
        return $this->belongsTo(Teacher::class);
    }
}
