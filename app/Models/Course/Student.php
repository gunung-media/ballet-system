<?php

namespace App\Models\Course;

use App\Enums\GenderEnum;
use App\Enums\StudentStatusEnum;
use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Student extends BaseModel
{
    protected $fillable = [
        'name',
        'surname',
        'gender',
        'birth_date',
        'address',
        'phone',
        'email',
        'photo',
        'wali_name',
        'wali_phone',
        'registration',
        'status',
        'note',
    ];

    protected function casts(): array
    {
        return [
            'gender' => GenderEnum::class,
            'status' => StudentStatusEnum::class,
        ];
    }

    static function validationRules(mixed $ignoredVal = null): array
    {
        return  [
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'classes' => 'array',
        ];
    }

    public function classes(): BelongsToMany
    {
        return $this->belongsToMany(ClassModel::class, 'class_students', 'student_id', 'class_id');
    }

    public function absences(): HasManyThrough
    {
        return $this->hasManyThrough(
            Absence::class,
            AbsenceStudent::class,
            'student_id',
            'id',
            'id',
            'absence_id'
        );
    }

    public function studentAbsences()
    {
        return $this->hasMany(AbsenceStudent::class, 'student_id', 'id');
    }
}
