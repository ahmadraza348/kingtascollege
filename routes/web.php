<?php

use App\Http\Controllers\Frontend\AboutController;
use App\Http\Controllers\Frontend\AdmissionController;
use App\Http\Controllers\Frontend\ContactController;
use App\Http\Controllers\Frontend\EligibilityController;
use App\Http\Controllers\Frontend\GalleryController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\NewsController;
use App\Http\Controllers\Frontend\PageController;
use App\Http\Controllers\Frontend\ProgramController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ContactMessageController;
use App\Http\Controllers\Admin\GalleryController as AdminGalleryController;
use App\Http\Controllers\Admin\AdmissionController as AdminAdmissionController;
use Illuminate\Support\Facades\Route;

Route::name('frontend.')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/about', [AboutController::class, 'about'])->name('about');

    // Programs
    Route::get('/programs', [ProgramController::class, 'all_programs'])->name('all_program');
    Route::get('/program-details', [ProgramController::class, 'programs'])->name('program-details');
    Route::get('/programs/{slug}', [ProgramController::class, 'bySlug'])->name('program-slug');

    // Admissions
    Route::get('/admission', [AdmissionController::class, 'admission'])->name('admission');
    Route::post('/admission', [AdmissionController::class, 'store'])->name('admission.store');
    Route::get('/admission/view-form', [AdmissionController::class, 'viewForm'])->name('admission.view-form');
    Route::get('/admission/form-preview', [AdmissionController::class, 'previewForm'])->name('admission.form-preview');
    Route::get('/admission/download-form', [AdmissionController::class, 'downloadForm'])->name('admission.download');
    Route::get('/admission/success', [AdmissionController::class, 'success'])->name('admission_success');
    // After applying, the student can view their own uploaded documents and submitted form.
    Route::get('/admission/success/form', [AdmissionController::class, 'myForm'])->name('admission.my-form');
    Route::get('/admission/success/documents/{key}', [AdmissionController::class, 'myDocument'])
        ->where('key', '[a-z_0-9]+')->name('admission.my-document');
    Route::get('/eligibility', [EligibilityController::class, 'eligibility'])->name('eligibility');

    // Academics
    Route::get('/clinical-training', [PageController::class, 'clinicalTraining'])->name('clinical-training');
    Route::get('/facilities', [PageController::class, 'facilities'])->name('facilities');
    Route::get('/faculty', [PageController::class, 'faculty'])->name('faculty');
    Route::get('/campus-life', [PageController::class, 'campusLife'])->name('campus-life');

    // News, events, notices
    Route::get('/news', [NewsController::class, 'news'])->name('news');
    Route::get('/news-details', [NewsController::class, 'details'])->name('news-details');
    Route::get('/events', [PageController::class, 'events'])->name('events');
    Route::get('/notices', [PageController::class, 'notices'])->name('notices');

    Route::get('/gallery', [GalleryController::class, 'gallery'])->name('gallery');
    Route::get('/faq', [PageController::class, 'faq'])->name('faq');

    // Contact
    Route::get('/contact', [ContactController::class, 'contact'])->name('contact');
    // Max 5 submissions per minute per visitor, to stop spam.
    Route::post('/contact', [ContactController::class, 'store'])->middleware('throttle:5,1')->name('contact.store');

    // Legal / utility
    Route::get('/privacy', [PageController::class, 'privacy'])->name('privacy');
    Route::get('/terms', [PageController::class, 'terms'])->name('terms');
    Route::get('/sitemap', [PageController::class, 'sitemap'])->name('sitemap');
});


// Admin Panel Routes
Route::prefix('admin')->group(function () {
    Route::get('login', [AuthController::class, 'login'])->name('admin.login');
    Route::post('login/submit', [AuthController::class, 'login_submit'])->name('admin.login.submit');
    Route::get('login/forget-password', [AuthController::class, 'forgetpass'])->name('admin.forgetpass');
    Route::post('login/forget-password/submit', [AuthController::class, 'submitforgetpass'])->name('admin.forgetpass.submit');
    Route::get('login/reset-password/{token}', [AuthController::class, 'show_reset_pass_form'])->name('reset.password.get');
    Route::post('login/reset-password/{token}', [AuthController::class, 'submit_reset_pass_form'])->name('reset.password.post');
});

Route::prefix('admin')->middleware('adminauth')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('admin.dashboard');
        Route::post('logout', [AuthController::class, 'logout'])->name('admin.logout');  
        
        Route::prefix('admissions')->name('admission.')->group(function () {
            Route::get('/', [AdminAdmissionController::class, 'index'])->name('index');
            Route::get('export', [AdminAdmissionController::class, 'export'])->name('export');
            Route::get('{admission}', [AdminAdmissionController::class, 'show'])->name('show');
            Route::patch('{admission}/status', [AdminAdmissionController::class, 'updateStatus'])->name('status');
            Route::patch('{admission}/notes', [AdminAdmissionController::class, 'updateNotes'])->name('notes');
            Route::get('{admission}/pdf', [AdminAdmissionController::class, 'pdf'])->name('pdf');
            Route::get('{admission}/documents/{key}', [AdminAdmissionController::class, 'document'])
                ->where('key', '[a-z_0-9]+')->name('document');
            Route::post('{admission}/documents/{key}/verify', [AdminAdmissionController::class, 'toggleDocument'])
                ->where('key', '[a-z_0-9]+')->name('document.verify');
            Route::delete('{admission}', [AdminAdmissionController::class, 'destroy'])->name('destroy');
        });

        Route::prefix('contact-messages')->name('contact-message.')->group(function () {
            Route::get('/', [ContactMessageController::class, 'index'])->name('index');
            Route::get('{message}', [ContactMessageController::class, 'show'])->name('show');
            Route::delete('{message}', [ContactMessageController::class, 'destroy'])->name('destroy');
        });

        Route::prefix('gallery')->name('gallery.')->group(function () {
            Route::get('/', [AdminGalleryController::class, 'index'])->name('index');
            Route::post('/', [AdminGalleryController::class, 'store'])->name('store');
            Route::delete('{gallery}', [AdminGalleryController::class, 'destroy'])->name('destroy');
        });


    }
);
