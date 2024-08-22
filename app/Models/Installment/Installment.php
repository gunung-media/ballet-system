<?php

namespace App\Models\Installment;

use App\Models\BaseModel;

class Installment extends BaseModel
{
    protected $fillable = [
        'title',
        'total',
        'notes'
    ];
}
