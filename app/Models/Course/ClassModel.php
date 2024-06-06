<?php

namespace App\Models\Course;

use App\Models\BaseModel;
use App\Traits\HasActive;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Validation\Rule;

class ClassModel extends BaseModel
{
    use HasActive;

    protected $table = 'classes';

    protected $fillable = [
        'name'
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }


    #[\Override]
    static function validationRules(mixed $ignoredVal = null): array
    {
        return  [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('classes', 'name')->ignore($ignoredVal)
            ],
            'is_active' => 'boolean',
            'schedule' => 'required|array|min:1',
        ];
    }

    public function schedules(): HasMany
    {
        return $this->hasMany(ClassSchedule::class, 'class_id');
    }

    public function students(): BelongsToMany
    {
        return $this->belongsToMany(Student::class, 'class_students', 'class_id', 'student_id');
    }
}
