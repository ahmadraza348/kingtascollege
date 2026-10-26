<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FeeHead extends Model
{
    public const FREQUENCIES = [
        'monthly'  => 'Every month',
        'one_time' => 'Once (at admission)',
        'per_exam' => 'Per examination',
        'manual'   => 'Only when added manually',
    ];

    protected $fillable = ['name', 'code', 'frequency', 'kind', 'is_system', 'is_active', 'sort_order'];

    protected $casts = ['is_system' => 'boolean', 'is_active' => 'boolean'];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /** Heads that can have an amount in a fee structure. */
    public function scopeForStructures($query)
    {
        return $query->active()->where('kind', 'charge')->whereIn('frequency', ['monthly', 'one_time', 'per_exam']);
    }
}