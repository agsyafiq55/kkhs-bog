<?php

use App\Livewire\Admin\Members\MembersList;
use Illuminate\Support\Facades\Route;
use App\Livewire\Admin\Events\EventsList;
use App\Livewire\Admin\Events\EventForm;
use App\Livewire\Admin\Events\EventShow;
use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use App\Livewire\Admin\AboutUs\AboutUsList;
use App\Livewire\Admin\AboutUs\AboutUsEdit;
use App\Livewire\Admin\AboutUs\Members\MemberList;
use App\Livewire\Admin\AboutUs\Members\MemberEdit;
use App\Livewire\Admin\AboutUs\Timeline\TimelineList; 
use App\Livewire\Admin\AboutUs\Timeline\TimelineEdit;
use App\Livewire\Admin\Announcements\AnnouncementsList;
use App\Livewire\Admin\Announcements\AnnouncementForm;
use App\Livewire\Admin\Announcements\AnnouncementShow;

Route::view('/admin/dashboard', '/admin/dashboard')
    ->middleware(['auth', 'verified'])
    ->name('admin.dashboard');

// Add this route as a simple alias
Route::redirect('/dashboard', '/admin/dashboard')->name('dashboard');

// Settings for Admin
Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('settings.profile');
    Route::get('settings/password', Password::class)->name('settings.password');
    Route::get('settings/appearance', Appearance::class)->name('settings.appearance');
});

// 1. Events Manager 
Route::middleware(['auth'])->group(function () {
    // List all events
    Route::get('/admin/events', EventsList::class)->name('admin.events');
    // Create a new event
    Route::get('/admin/events/create', EventForm::class)->name('admin.events.create');
    // Edit an existing event
    Route::get('/admin/events/edit/{eventId}', EventForm::class)->name('admin.events.edit');
    // View a single event (detailed view)
    Route::get('/admin/events/show/{eventId}', EventShow::class)->name('admin.events.show');
});

// 2. Gallery Manager
Route::middleware(['auth'])->group(function () {
    // List all gallery images
    Route::get('/admin/gallery', App\Livewire\Admin\Gallery\GalleryList::class)->name('admin.gallery');
    // Create/edit a gallery image
    Route::get('/admin/gallery/edit/{galleryId?}', App\Livewire\Admin\Gallery\GalleryEdit::class)->name('admin.gallery.edit');
    // View a single gallery image
    Route::get('/admin/gallery/{galleryId}', App\Livewire\Admin\Gallery\GalleryShow::class)->name('admin.gallery.show');
});

// 3. About Us 
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    // Main About Us page
    Route::get('/aboutus', AboutUsList::class)->name('aboutus');

    // About Us create and edit pages
    Route::get('/aboutus/create', AboutUsEdit::class)->name('aboutus.create');
    Route::get('/aboutus/edit/{aboutUsId}', AboutUsEdit::class)->name('aboutus.edit');

    // 3a. Members management
    Route::get('/aboutus/members', MemberList::class)->name('aboutus.members.list');
    Route::get('/aboutus/members/create', MemberEdit::class)->name('aboutus.members.create');
    Route::get('/aboutus/members/edit/{memberId}', MemberEdit::class)->name('aboutus.members.edit');

    // 3b. Timeline management 
    Route::get('/timeline', TimelineList::class)->name('timeline');
    Route::get('/timeline/create', App\Livewire\Admin\AboutUs\Timeline\TimelineEdit::class)->name('timeline.create');
    Route::get('/timeline/edit/{cardId}', App\Livewire\Admin\AboutUs\Timeline\TimelineEdit::class)->name('timeline.edit');
});

// 4. Achievements
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    // Academic Achievements
    Route::prefix('achievements/academic')->name('achievements.academic.')->group(function () {
        Route::get('/', App\Livewire\Admin\Achievements\AcademicAchievementsList::class)->name('index');
        Route::get('/create', App\Livewire\Admin\Achievements\AcademicAchievementForm::class)->name('create');
        Route::get('/{id}/edit', App\Livewire\Admin\Achievements\AcademicAchievementForm::class)->name('edit');
    });

    // Co-curricular Achievements
    Route::prefix('achievements/cocurricular')->name('achievements.cocurricular.')->group(function () {
        Route::get('/', App\Livewire\Admin\Achievements\CocurricularAchievementsList::class)->name('index');
        Route::get('/create', App\Livewire\Admin\Achievements\CocurricularAchievementForm::class)->name('create');
        Route::get('/{id}/edit', App\Livewire\Admin\Achievements\CocurricularAchievementForm::class)->name('edit');
    });
});

// 5. Announcements
Route::middleware(['auth'])->group(function () {
    // List all announcements
    Route::get('/admin/announcements', App\Livewire\Admin\Announcements\AnnouncementsList::class)->name('admin.announcements');
    // Create a new announcement
    Route::get('/admin/announcements/create', App\Livewire\Admin\Announcements\AnnouncementForm::class)->name('admin.announcements.create');
    // Edit an existing announcement
    Route::get('/admin/announcements/edit/{announcementId}', App\Livewire\Admin\Announcements\AnnouncementForm::class)->name('admin.announcements.edit');
    // View a single announcement (detailed view)
    Route::get('/admin/announcements/show/{announcementId}', App\Livewire\Admin\Announcements\AnnouncementShow::class)->name('admin.announcements.show');
});

// 6. Contact Us Management
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/contactus', App\Livewire\Admin\ContactUs\ContactUsDisplay::class)->name('contactus.display');
    Route::get('/contactus/edit/{contactUsId?}', App\Livewire\Admin\ContactUs\ContactUsForm::class)->name('contactus.edit');
});
