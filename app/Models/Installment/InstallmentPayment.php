<?php

namespace App\Models\Installment;

use App\Models\BaseModel;
use App\Models\Course\Student;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InstallmentPayment extends BaseModel
{
    protected $fillable = [
        'installment_id',
        'amount',
        'student_id'
    ];

    public function installment(): BelongsTo
    {
        return $this->belongsTo(Installment::class);
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }
}
