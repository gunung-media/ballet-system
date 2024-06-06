<?php

namespace App\Models\Course;

use App\Enums\GenderEnum;
use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Student extends BaseModel
{
    protected $fillable = [
        'name',
        'gender',
        'birth_date',
        'address',
        'phone',
        'email',
        'photo',
        'wali_name',
        'wali_phone',
        'registration',
        'note',
    ];

    protected function casts(): array
    {
        return [
            'gender' => GenderEnum::class
        ];
    }

    static function validationRules(mixed $ignoredVal = null): array
    {
        return  [];
    }

    public function classes(): BelongsToMany
    {
        return $this->belongsToMany(ClassModel::class, 'class_students', 'student_id', 'class_id');
    }
}
