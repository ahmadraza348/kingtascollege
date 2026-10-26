<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FeeVoucherItem extends Model
{
    protected $fillable = ['fee_voucher_id', 'fee_head_id', 'title', 'amount', 'source', 'charged_on', 'note', 'created_by'];

    protected $casts = ['amount' => 'decimal:2', 'charged_on' => 'date'];

    public function voucher(): BelongsTo
    {
        return $this->belongsTo(FeeVoucher::class, 'fee_voucher_id');
    }

    public function head(): BelongsTo
    {
        return $this->belongsTo(FeeHead::class, 'fee_head_id');
    }
}