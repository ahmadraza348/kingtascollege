<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ExpensePayment extends Model
{
    public const METHODS = [
        'cash'          => 'Cash',
        'bank_transfer' => 'Bank transfer',
        'cheque'        => 'Cheque',
        'online'        => 'Online / mobile wallet',
    ];

    protected $fillable = [
        'expense_id', 'payment_date', 'amount', 'method', 'reference_no', 'remarks', 'status',
        'cancel_reason', 'cancelled_at', 'submit_token', 'created_by',
    ];

    protected $casts = [
        'payment_date' => 'date',
        'amount'       => 'decimal:2',
        'cancelled_at' => 'datetime',
    ];

    public function expense(): BelongsTo
    {
        return $this->belongsTo(Expense::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'created_by');
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    protected function methodLabel(): Attribute
    {
        return Attribute::get(fn () => self::METHODS[$this->method] ?? $this->method);
    }
}
