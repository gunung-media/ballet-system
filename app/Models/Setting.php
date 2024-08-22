<?php

namespace App\Models;

class Setting extends BaseModel
{
    protected $fillable = [
        'receipt_logo',
        'receipt_title',
        'receipt_address',
        'receipt_text_footer',
    ];
}
