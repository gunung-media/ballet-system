<?php

namespace App\Models;

use App\Enums\AbsenceStateEnum;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EmployeeAbsence extends BaseModel
{
    protected $fillable = [
        'employee_id',
        'date',
        'state'
    ];

    protected function casts(): array
    {
        return [
            'state' => AbsenceStateEnum::class
        ];
    }

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }
}
