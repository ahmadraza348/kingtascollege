<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AdmissionLog extends Model
{
    protected $fillable = ['admission_id', 'admin_id', 'from_status', 'to_status', 'remarks'];

    public function admin(): BelongsTo
    {
        return $this->belongsTo(Admin::class);
    }
}
