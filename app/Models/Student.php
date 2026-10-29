<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Student extends Model
{
    use SoftDeletes;

    /** Only "active" students are marked present by default in attendance. */
    public const STATUSES = [
        'active'    => 'Active',
        'inactive'  => 'Inactive',
        'graduated' => 'Graduated',
        'left'      => 'Left / Dropped',
    ];

    public const STATUS_COLORS = [
        'active'    => 'success',
        'inactive'  => 'secondary',
        'graduated' => 'primary',
        'left'      => 'danger',
    ];

    public const GENDERS = ['Male', 'Female', 'Other'];

    public const BLOOD_GROUPS = ['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'];

    public const PROVINCES = [
        'Punjab', 'Sindh', 'Khyber Pakhtunkhwa', 'Balochistan', 'Islamabad Capital Territory', 'Other',
    ];

    protected $fillable = [
        'admission_id', 'admission_form_number',
        'roll_number', 'full_name', 'father_name', 'gender', 'date_of_birth', 'cnic', 'blood_group', 'photo_path',
        'phone', 'whatsapp', 'email', 'guardian_name', 'guardian_phone',
        'street', 'city', 'district', 'province',
        'qualification', 'institution', 'obtained_marks', 'total_marks', 'percentage',
        'school_class_id', 'section_id', 'program', 'session', 'monthly_tuition_fee', 'admission_date', 'status',
        'notes',
    ];

    protected $casts = [
        'date_of_birth'       => 'date',
        'admission_date'      => 'date',
        'obtained_marks'      => 'decimal:2',
        'total_marks'         => 'decimal:2',
        'percentage'          => 'decimal:2',
        'monthly_tuition_fee' => 'decimal:2',
    ];

    public function schoolClass(): BelongsTo
    {
        return $this->belongsTo(SchoolClass::class, 'school_class_id');
    }

    public function section(): BelongsTo
    {
        return $this->belongsTo(Section::class);
    }

    public function admission(): BelongsTo
    {
        return $this->belongsTo(Admission::class);
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    protected function statusLabel(): Attribute
    {
        return Attribute::get(fn () => self::STATUSES[$this->status] ?? ucfirst($this->status));
    }

    protected function statusColor(): Attribute
    {
        return Attribute::get(fn () => self::STATUS_COLORS[$this->status] ?? 'secondary');
    }

    protected function photoUrl(): Attribute
    {
        return Attribute::get(fn () => $this->photo_path
            ? asset($this->photo_path)
            : asset('backend/assets/img/noimage.png'));
    }

    protected function age(): Attribute
    {
        return Attribute::get(fn () => $this->date_of_birth?->age);
    }

    protected function whatsappLink(): Attribute
    {
        return Attribute::get(function () {
            $digits = preg_replace('/\D/', '', $this->whatsapp ?: $this->phone);

            if (str_starts_with($digits, '0')) {
                $digits = '92' . substr($digits, 1);
            }

            return 'https://wa.me/' . $digits;
        });
    }
        public function feeVouchers(): HasMany
    {
        return $this->hasMany(FeeVoucher::class);
    }
}