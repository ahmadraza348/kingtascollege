<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;

/**
 * Simple content pages that only render a view.
 */
class PageController extends Controller
{
    public function faculty()
    {
        return view('frontend.faculty');
    }
    public function facilities()
    {
        return view('frontend.facilities');
    }
    public function clinicalTraining()
    {
        return view('frontend.clinical_training');
    }
    public function campusLife()
    {
        return view('frontend.campus_life');
    }
    public function events()
    {
        return view('frontend.events');
    }
    public function notices()
    {
        return view('frontend.notices');
    }
    public function faq()
    {
        return view('frontend.faq');
    }
    public function privacy()
    {
        return view('frontend.privacy');
    }
    public function terms()
    {
        return view('frontend.terms');
    }
    public function sitemap()
    {
        return view('frontend.sitemap');
    }
}
