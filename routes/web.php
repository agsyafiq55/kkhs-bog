<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\AboutUsController;
use App\Http\Controllers\AnnouncementController;
use Illuminate\Support\Facades\Auth;

require __DIR__.'/auth.php';
require __DIR__.'/admin.php';

// // To creat sym link in production server
// Route::get('/linkstorage', function () {
//     Artisan::call('storage:link');
// });

// Landing Page
// If user is authenticated, redirect to dashboard, otherwise show welcome page
Route::get('/', function() {
    if (Auth::check()) {
        return redirect()->route('dashboard');
    }
    return app(GuestController::class)->index();
})->name('home');

// 1. Events Page
// Index: List all events
Route::get('/events', [EventController::class, 'index'])->name('events.index');
// Show: Display a single event's details
Route::get('/events/{id}', [EventController::class, 'show'])->name('events.show');

// 2. Gallery 
// Guest routes for gallery
Route::get('/gallery', [App\Http\Controllers\GalleryController::class, 'index'])->name('gallery');
Route::get('/gallery/{id}', [App\Http\Controllers\GalleryController::class, 'show'])->name('gallery.show');

// 3. Announcements
Route::get('/announcements', [AnnouncementController::class, 'index'])->name('announcements.index');
Route::get('/announcements/{id}', [AnnouncementController::class, 'show'])->name('announcements.show');

// 4. About Us 
Route::get('/about-us', [App\Http\Controllers\AboutUsController::class, 'index'])->name('aboutus');

//5. Contact Us
Route::get('/contact-us', [App\Http\Controllers\ContactUsController::class, 'index'])->name('contact-us');




