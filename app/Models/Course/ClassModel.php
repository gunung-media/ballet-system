<?php

namespace App\Models\Course;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Validation\Rule;

class ClassModel extends BaseModel
{
    protected $table = 'classes';

    #[\Override]
    static function validationRules(mixed $ignoredVal = null): array
    {
        return  [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique(table: 'classes', column: 'name')->ignore($ignoredVal)
            ],
            'is_active' => 'boolean'
        ];
    }

    public function schedules(): HasMany
    {
        return $this->hasMany(ClassSchedule::class);
    }
}
