<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AttendanceLog extends Model
{
    public const STATUSES = [
        'present'  => 'Present',
        'absent'   => 'Absent',
        'late'     => 'Late',
        'excused'  => 'Excused',   // approved leave
        'half_day' => 'Half Day',
    ];

    public const LETTERS = ['present' => 'P', 'absent' => 'A', 'late' => 'L', 'excused' => 'E', 'half_day' => 'H'];

    public const COLORS = [
        'present' => '#28c76f', 'absent' => '#ea5455', 'late' => '#ff9f43', 'excused' => '#00cfe8', 'half_day' => '#7367f0',
    ];

    // `date` is deliberately not cast: it stays a "Y-m-d" string, which is what we group and compare by.
    protected $fillable = [
        'student_id', 'school_class_id', 'section_id', 'date', 'status', 'marked_by', 'updated_by',
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

    public function updater(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'updated_by');
    }
}