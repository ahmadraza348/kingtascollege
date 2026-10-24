<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AttendanceSession extends Model
{
    protected $fillable = ['school_class_id', 'section_id', 'date', 'marked_by', 'updated_by'];

    public function section(): BelongsTo
    {
        return $this->belongsTo(Section::class);
    }

    public function marker(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'marked_by');
    }

    public function updater(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'updated_by');
    }
}