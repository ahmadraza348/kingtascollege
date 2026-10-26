<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FeePayment extends Model
{
    public const METHODS = [
        'cash'         => 'Cash (at college)',
        'bank_deposit' => 'Bank deposit (voucher)',
    ];

    public const STATUSES = ['pending' => 'Pending verification', 'verified' => 'Verified', 'rejected' => 'Rejected', 'cancelled' => 'Cancelled'];

    public const STATUS_COLORS = ['pending' => 'warning', 'verified' => 'success', 'rejected' => 'danger', 'cancelled' => 'secondary'];

    protected $fillable = [
        'receipt_number', 'student_id', 'payment_date', 'method', 'amount', 'bank_name', 'branch', 'reference_no',
        'dedupe_key', 'submit_token', 'preferred_voucher_id', 'status', 'balance_after', 'verified_at', 'verified_by',
        'status_reason', 'remarks', 'received_by',
    ];

    protected $casts = [
        'payment_date'  => 'date',
        'amount'        => 'decimal:2',
        'balance_after' => 'decimal:2',
        'verified_at'   => 'datetime',
    ];

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class)->withTrashed();
    }

    public function allocations(): HasMany
    {
        return $this->hasMany(FeePaymentAllocation::class);
    }

    public function logs(): HasMany
    {
        return $this->hasMany(FeeAuditLog::class)->latest('id');
    }

    public function receiver(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'received_by');
    }

    public function verifier(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'verified_by');
    }

    protected function methodLabel(): Attribute
    {
        return Attribute::get(fn () => self::METHODS[$this->method] ?? $this->method);
    }

    protected function statusLabel(): Attribute
    {
        return Attribute::get(fn () => self::STATUSES[$this->status] ?? $this->status);
    }

    protected function statusColor(): Attribute
    {
        return Attribute::get(fn () => self::STATUS_COLORS[$this->status] ?? 'secondary');
    }
}
