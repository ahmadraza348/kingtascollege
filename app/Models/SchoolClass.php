<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SchoolClass extends Model
{
    protected $table = 'school_classes';

    /** Same list as the admission form. */
    public const PROGRAMS = [
        'BSN Generic',
        'Post RN',
        'LHV (Lady Health Visitor)',
        'CMW (Community Midwife)',
        'CNA (Certified Nursing Assistant)',
        'Radiography Technology + F.Sc',
        'Medical Lab Technology + F.Sc',
        'Dental Technician',
        'Operation Theater Technology + F.Sc',
        'Dispenser + F.Sc',
        'B-Category Pharmacy Technician',
        'Anesthesia Technician',
    ];

    protected $fillable = [
        'name',
        'code',
        'program',
        'description',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function sections(): HasMany
    {
        return $this->hasMany(Section::class, 'school_class_id');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

        public function students(): HasMany
    {
        return $this->hasMany(Student::class, 'school_class_id');
    }
}