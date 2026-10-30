<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/** Total payable fee of one student, split into installments (each installment is a FeeVoucher). */
class FeePlan extends Model
{
    protected $fillable = [
        'student_id', 'session', 'total_fee', 'discount', 'net_fee', 'notes', 'status', 'cancelled_at', 'created_by',
    ];

    protected $casts = [
        'total_fee'    => 'decimal:2',
        'discount'     => 'decimal:2',
        'net_fee'      => 'decimal:2',
        'cancelled_at' => 'datetime',
    ];

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class)->withTrashed();
    }

    public function vouchers(): HasMany
    {
        return $this->hasMany(FeeVoucher::class, 'fee_plan_id');
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
}
