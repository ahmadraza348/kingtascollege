<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\ContactFormRequest;
use App\Services\Frontend\ContactService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ContactController extends Controller
{
    public function contact(): View
    {
        return view('frontend.contact');
    }

    public function store(ContactFormRequest $request, ContactService $contactService): RedirectResponse
    {
        // Validation already passed (ContactFormRequest). The service saves the query
        // and emails the college. The visitor's query is saved even if the email fails,
        // so we always show a success message.
        $contactService->create($request->validated());

        toastr()->success('Thank you. Your query has been sent. Our admissions team will contact you soon.');

        return redirect()->route('frontend.contact');
    }
}
