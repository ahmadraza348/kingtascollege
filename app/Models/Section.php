<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Section extends Model
{
    protected $fillable = [
        'school_class_id',
        'name',
        'room',
        'class_teacher',
        'capacity',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function schoolClass(): BelongsTo
    {
        return $this->belongsTo(SchoolClass::class, 'school_class_id');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /** "BSN Generic - Year 1 / A" */
    public function getFullNameAttribute(): string
    {
        return ($this->schoolClass?->name ?? '') . ' / ' . $this->name;
    }

        public function students(): HasMany
    {
        return $this->hasMany(Student::class, 'section_id');
    }
}