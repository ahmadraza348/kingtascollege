<?php

namespace App\Models;

use App\Support\FeeHelper;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FeeVoucher extends Model
{
    public const TYPES = [
        'monthly'     => 'Monthly Fee',
        'admission'   => 'Admission Fee',
        'exam'        => 'Examination Fee',
        'readmission' => 'Readmission Fee',
        'opening'     => 'Previous Dues (Opening Balance)',
        'other'       => 'Other Charges',
    ];

    public const STATUSES = ['unpaid' => 'Unpaid', 'partial' => 'Partly Paid', 'paid' => 'Paid', 'cancelled' => 'Cancelled'];

    public const STATUS_COLORS = ['unpaid' => 'danger', 'partial' => 'warning', 'paid' => 'success', 'cancelled' => 'secondary'];

    protected $fillable = [
        'voucher_number', 'student_id', 'school_class_id', 'section_id', 'roll_number', 'type', 'period', 'unique_key',
        'issue_date', 'due_date', 'total_amount', 'paid_amount', 'balance', 'status',
        'notes', 'cancel_reason', 'cancelled_at', 'cancelled_by', 'created_by',
    ];

    protected $casts = [
        'issue_date'      => 'date',
        'due_date'        => 'date',
        'total_amount'    => 'decimal:2',
        'paid_amount'     => 'decimal:2',
        'balance'         => 'decimal:2',
        'cancelled_at'    => 'datetime',
    ];

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class)->withTrashed();
    }

    public function schoolClass(): BelongsTo
    {
        return $this->belongsTo(SchoolClass::class, 'school_class_id');
    }

    public function section(): BelongsTo
    {
        return $this->belongsTo(Section::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(FeeVoucherItem::class)->orderBy('id');
    }

    public function allocations(): HasMany
    {
        return $this->hasMany(FeePaymentAllocation::class);
    }

    /** Still waiting for money. */
    public function scopeOpen($query)
    {
        return $query->whereIn('status', ['unpaid', 'partial']);
    }

    public function scopeOverdue($query)
    {
        return $query->open()->where('due_date', '<', FeeHelper::today()->toDateString());
    }

    protected function isOverdue(): Attribute
    {
        return Attribute::get(fn () => in_array($this->status, ['unpaid', 'partial'], true)
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

    protected function typeLabel(): Attribute
    {
        return Attribute::get(fn () => self::TYPES[$this->type] ?? $this->type);
    }

    protected function periodLabel(): Attribute
    {
        return Attribute::get(fn () => FeeHelper::periodLabel($this->period));
    }
}