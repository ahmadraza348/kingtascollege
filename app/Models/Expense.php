<?php

namespace App\Models;

use App\Support\FeeHelper;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Expense extends Model
{
    public const STATUSES = ['unpaid' => 'Unpaid', 'partial' => 'Partly paid', 'paid' => 'Paid', 'cancelled' => 'Cancelled'];

    public const STATUS_COLORS = ['unpaid' => 'danger', 'partial' => 'warning', 'paid' => 'success', 'cancelled' => 'secondary'];

    /** Statuses that still owe money (the school's "dues payable"). */
    public const OPEN = ['unpaid', 'partial'];

    protected $fillable = [
        'expense_number', 'expense_category_id', 'title', 'payee', 'reference_no', 'expense_date', 'due_date',
        'amount', 'paid_amount', 'status', 'description', 'attachment_path', 'attachment_name', 'submit_token',
        'status_reason', 'cancelled_at', 'cancelled_by', 'created_by',
    ];

    protected $casts = [
        'expense_date' => 'date',
        'due_date'     => 'date',
        'amount'       => 'decimal:2',
        'paid_amount'  => 'decimal:2',
        'cancelled_at' => 'datetime',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(ExpenseCategory::class, 'expense_category_id');
    }

    public function payments(): HasMany
    {
        return $this->hasMany(ExpensePayment::class)->latest('payment_date')->latest('id');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'created_by');
    }

    public function scopeNotCancelled($query)
    {
        return $query->where('status', '!=', 'cancelled');
    }

    /** Bills that still have something left to pay. */
    public function scopeOpen($query)
    {
        return $query->whereIn('status', self::OPEN);
    }

    /** Open bills whose due date has already passed. */
    public function scopeOverdue($query)
    {
        return $query->open()->whereNotNull('due_date')->whereDate('due_date', '<', FeeHelper::today()->toDateString());
    }

    protected function balance(): Attribute
    {
        return Attribute::get(fn () => $this->status === 'cancelled'
            ? 0.0
            : max(0.0, round((float) $this->amount - (float) $this->paid_amount, 2)));
    }

    protected function isOverdue(): Attribute
    {
        return Attribute::get(fn () => in_array($this->status, self::OPEN, true)
            && $this->due_date !== null
            && $this->due_date->toDateString() < FeeHelper::today()->toDateString());
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
