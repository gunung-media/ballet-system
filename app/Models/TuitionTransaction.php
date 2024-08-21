<?php

namespace App\Models;

use App\Enums\DiscountTypeEnum;
use App\Enums\StudioTypeEnum;
use App\Enums\TuitionTypeEnum;
use App\Models\Course\ClassModel;
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
        'studio_type',
        'discount_type',
        'discount',
        'class_id'
    ];

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function class(): BelongsTo
    {
        return $this->belongsTo(ClassModel::class);
    }

    protected function casts(): array
    {
        return [
            'tuition_type' => TuitionTypeEnum::class,
            'studio_type' => StudioTypeEnum::class,
            'discount_type' => DiscountTypeEnum::class
        ];
    }
}
