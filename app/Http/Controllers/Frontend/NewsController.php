<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;

class NewsController extends Controller
{
    public function news()
    {
        return view('frontend.news');
    }

    // Article is chosen client-side from ?article=<id> (see filters.js)
    public function details()
    {
        return view('frontend.news_details');
    }
}
