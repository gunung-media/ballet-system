<?php

namespace App\Models\Course;

use App\Enums\TeacherStatus;
use App\Models\BaseModel;

class Teacher extends BaseModel
{
    protected $fillable = [
        'name',
        'photo',
        'identity_number',
        'birth_date',
        'gender',
        'email',
        'phone',
        'address',
        'join_date',
        'status',
    ];

    public function casts(): array
    {
        return [
            'status'  => TeacherStatus::class
        ];
    }
}
