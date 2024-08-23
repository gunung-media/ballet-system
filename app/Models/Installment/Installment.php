<?php

namespace App\Models\Installment;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Installment extends BaseModel
{
    protected $fillable = [
        'title',
        'total',
        'notes'
    ];

    protected $appends = ['is_paid'];

    public function payments(): HasMany
    {
        return $this->hasMany(InstallmentPayment::class);
    }

    public function isPaid(): Attribute
    {
        return Attribute::make(
            get: fn($value) => $this->total <= $this->payments()->sum('amount'),
        );
    }
}
