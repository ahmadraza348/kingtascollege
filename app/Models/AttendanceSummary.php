<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AttendanceSummary extends Model
{
    protected $fillable = [
        'student_id', 'school_class_id', 'section_id', 'year', 'month',
        'present', 'absent', 'late', 'excused', 'half_day', 'marked', 'percentage',
    ];
}