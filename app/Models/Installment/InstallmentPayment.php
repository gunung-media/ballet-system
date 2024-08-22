<?php

namespace App\Models\Installment;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InstallmentPayment extends BaseModel
{
    protected $fillable = [
        'installment_id',
        'amount',
    ];

    public function installment(): BelongsTo
    {
        return $this->belongsTo(Installment::class);
    }
}
