<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GalleryImage extends Model
{
    protected $fillable = [
        'title',
        'image_path',
    ];

    /** Public URL of the image (files live in /public/uploads/gallery). */
    public function getUrlAttribute(): string
    {
        return asset($this->image_path);
    }
}
