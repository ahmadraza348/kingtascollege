<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactMessage extends Model
{
    protected $fillable = [
        'name',
        'phone',
        'email',
        'subject',
        'program',
        'message',
        'email_sent',
    ];

    protected $casts = [
        'email_sent' => 'boolean',
    ];
}
