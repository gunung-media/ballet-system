<?php

namespace App\Models\Course;

use App\Enums\EmployeeTypeEnum;
use App\Enums\GenderEnum;
use App\Enums\TeacherStatus;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Teacher extends Authenticatable
{
    static function validationRules(mixed $ignoredVal = null): array
    {
        return  [];
    }

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
        'type',
        'password'
    ];

    protected function casts(): array
    {
        return [
            'gender' => GenderEnum::class,
            'status'  => TeacherStatus::class,
            'type'  => EmployeeTypeEnum::class,
        ];
    }
}
