<?php

namespace App\Models\Installment;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Installment extends BaseModel
{
    protected $fillable = [
        'title',
        'total',
        'notes'
    ];

    public function payments(): HasMany
    {
        return $this->hasMany(InstallmentPayment::class);
    }
}
