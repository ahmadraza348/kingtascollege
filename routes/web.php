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
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\StudentImportController;
use App\Http\Controllers\Admin\SchoolClassController;
use App\Http\Controllers\Admin\SectionController;
use App\Http\Controllers\Admin\AttendanceController;
use App\Http\Controllers\Admin\AttendanceDashboardController;
use App\Http\Controllers\Admin\AttendanceReportController;
use App\Http\Controllers\Admin\SchoolHolidayController;
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
    Route::post('login/submit', [AuthController::class, 'login_submit'])->middleware('throttle:10,1')->name('admin.login.submit');
    Route::get('login/forget-password', [AuthController::class, 'forgetpass'])->name('admin.forgetpass');
    Route::post('login/forget-password/submit', [AuthController::class, 'submitforgetpass'])->middleware('throttle:5,1')->name('admin.forgetpass.submit');
    Route::get('login/reset-password/{token}', [AuthController::class, 'show_reset_pass_form'])->name('reset.password.get');
    Route::post('login/reset-password/{token}', [AuthController::class, 'submit_reset_pass_form'])->middleware('throttle:10,1')->name('reset.password.post');
});

Route::prefix('admin')->middleware('adminauth')->group(
    function () {
        Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('admin.dashboard');
        Route::post('logout', [AuthController::class, 'logout'])->name('admin.logout');
        Route::get('change-password', [AuthController::class, 'changePasswordForm'])->name('admin.password.change');
        Route::post('change-password', [AuthController::class, 'changePasswordSubmit'])->name('admin.password.update');

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

        // Academics: classes & sections
        Route::resource('classes', SchoolClassController::class)
            ->except('show')
            ->parameters(['classes' => 'schoolClass'])
            ->names('school-class');

        Route::get('sections/by-class/{schoolClass}', [SectionController::class, 'byClass'])->name('section.by-class');

        Route::resource('sections', SectionController::class)
            ->except('show')
            ->names('section');

        // Students
        Route::prefix('students')->name('student.')->group(function () {
            Route::get('/', [StudentController::class, 'index'])->name('index');
            Route::get('create', [StudentController::class, 'create'])->name('create');
            Route::post('/', [StudentController::class, 'store'])->name('store');
            Route::get('admission-lookup', [StudentController::class, 'admissionLookup'])->name('admission-lookup');
            Route::post('bulk', [StudentController::class, 'bulk'])->name('bulk');

            Route::get('import', [StudentImportController::class, 'create'])->name('import');
            Route::get('import/template', [StudentImportController::class, 'template'])->name('import.template');
            Route::post('import/preview', [StudentImportController::class, 'preview'])->name('import.preview');
            Route::post('import/commit', [StudentImportController::class, 'commit'])->name('import.commit');

            Route::post('{id}/restore', [StudentController::class, 'restore'])->whereNumber('id')->name('restore');
            Route::get('{student}', [StudentController::class, 'show'])->name('show');
            Route::get('{student}/edit', [StudentController::class, 'edit'])->name('edit');
            Route::put('{student}', [StudentController::class, 'update'])->name('update');
            Route::delete('{student}', [StudentController::class, 'destroy'])->name('destroy');
        });

        // Attendance
        Route::prefix('attendance')->name('attendance.')->group(function () {
            Route::get('/', [AttendanceDashboardController::class, 'index'])->name('dashboard');

            Route::get('mark', [AttendanceController::class, 'index'])->name('mark');
            Route::post('mark', [AttendanceController::class, 'save'])->name('save');

            Route::get('reports', [AttendanceReportController::class, 'index'])->name('report');
            Route::get('reports/pdf', [AttendanceReportController::class, 'pdf'])->name('report.pdf');
            Route::get('reports/export/{format}', [AttendanceReportController::class, 'export'])
                ->whereIn('format', ['xlsx', 'csv'])->name('report.export');

            Route::get('holidays', [SchoolHolidayController::class, 'index'])->name('holidays');
            Route::post('holidays', [SchoolHolidayController::class, 'store'])->name('holidays.store');
            Route::delete('holidays/{holiday}', [SchoolHolidayController::class, 'destroy'])->name('holidays.destroy');
        });
    }
);
