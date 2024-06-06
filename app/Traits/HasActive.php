<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

trait HasActive
{
    public function scopeActive(Builder $query): void
    {
        $query->where('is_active', 1);
    }
}
