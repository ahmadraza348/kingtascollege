<?php

use App\Http\Controllers\Frontend\AboutController;
use App\Http\Controllers\Frontend\AdmissionController;
use App\Http\Controllers\Frontend\ContactController;
use App\Http\Controllers\Frontend\GalleryController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\ProgramDetailController;
use Illuminate\Support\Facades\Route;

Route::name('frontend.')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/about', [AboutController::class, 'about'])->name('about');
    Route::get('/programs', [ProgramDetailController::class, 'programs'])->name('program-details');
    Route::get('/contact', [ContactController::class, 'contact'])->name('contact');
    Route::get('/admission', [AdmissionController::class, 'admission'])->name('admission');
    Route::get('/gallery', [GalleryController::class, 'gallery'])->name('gallery');
}); 
