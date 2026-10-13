<?php

namespace App\Models;

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
}
