<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\GalleryImage;

class GalleryController extends Controller
{
    public function gallery()
    {
        $images = GalleryImage::latest()->get();

        return view('frontend.gallery', compact('images'));
    }
}
