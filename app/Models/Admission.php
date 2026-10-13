<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Admission extends Model
{
    protected $fillable = [
        'full_name',
        'father_name',
        'date_of_birth',
        'gender',
        'cnic',
        'phone',
        'whatsapp',
        'email',
        'qualification',
        'institution',
        'obtained_marks',
        'total_marks',
        'percentage',
        'program',
        'session',
        'notes',
        'street',
        'city',
        'district',
        'province',
        'cnic_front_path',
        'cnic_back_path',
        'domicile_document_path',
        'degree_documents',
        'personal_picture_path',
        'other_documents',
        'terms_accepted',
        'status',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'obtained_marks' => 'decimal:2',
        'total_marks' => 'decimal:2',
        'percentage' => 'decimal:2',
        'degree_documents' => 'array',
        'other_documents' => 'array',
        'terms_accepted' => 'boolean',
    ];

    /**
     * Human-friendly admission form number, e.g. KTC-2026-00042.
     * Derived from the record id + year, so it is stable and needs no extra column.
     */
    protected function formNumber(): Attribute
    {
        return Attribute::get(function () {
            $year = ($this->created_at ?? now())->format('Y');

            return sprintf('KTC-%s-%05d', $year, $this->id);
        });
    }
}
