<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FeeAuditLog extends Model
{
    public $timestamps = false;

    protected $fillable = ['student_id', 'fee_voucher_id', 'fee_payment_id', 'action', 'description', 'amount', 'admin_id', 'created_at'];

    protected $casts = ['created_at' => 'datetime', 'amount' => 'decimal:2'];

    public function admin(): BelongsTo
    {
        return $this->belongsTo(Admin::class);
    }

    /** One line in the history. Called by the services whenever money or a voucher changes. */
    public static function record(string $action, string $description, ?int $studentId, ?int $voucherId = null, ?int $paymentId = null, ?float $amount = null): void
    {
        static::create([
            'student_id'     => $studentId,
            'fee_voucher_id' => $voucherId,
            'fee_payment_id' => $paymentId,
            'action'         => $action,
            'description'    => mb_substr($description, 0, 500),
            'amount'         => $amount,
            'admin_id'       => auth('admin')->id(),
            'created_at'     => now(),
        ]);
    }
}