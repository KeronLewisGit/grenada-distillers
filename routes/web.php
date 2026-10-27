<?php

use App\Http\Controllers\Admin;
use App\Http\Controllers\AgeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CareerController;
use App\Http\Controllers\LeadFormController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\RumController;
use Illuminate\Support\Facades\Route;

// Age check first: everything about the rum sits behind it. Legal pages and the sitemap do not.
Route::get('/age', [AgeController::class, 'show'])->name('age.show');
Route::post('/age', [AgeController::class, 'store'])->middleware('throttle:forms')->name('age.store');
Route::get('/privacy', [PageController::class, 'privacy'])->name('privacy');
Route::get('/photo-credits', [PageController::class, 'credits'])->name('credits');
Route::get('/sitemap.xml', [PageController::class, 'sitemap'])->name('sitemap');

Route::middleware('age')->group(function () {
    Route::get('/', [PageController::class, 'home'])->name('home');
    Route::get('/rums', [RumController::class, 'index'])->name('rums.index');
    Route::get('/rums/{rum}', [RumController::class, 'show'])->name('rums.show');
    Route::get('/heritage', [PageController::class, 'heritage'])->name('heritage');

    Route::get('/tours', [LeadFormController::class, 'tours'])->name('tours');
    Route::get('/trade', [LeadFormController::class, 'trade'])->name('trade');
    Route::get('/careers', [CareerController::class, 'index'])->name('careers.index');
    Route::get('/careers/apply', [LeadFormController::class, 'apply'])->name('careers.apply');
    Route::get('/careers/{job}', [CareerController::class, 'show'])->name('careers.show');
    Route::get('/contact', [PageController::class, 'contact'])->name('contact');
    Route::get('/thanks', [LeadFormController::class, 'thanks'])->name('thanks');
    Route::get('/sitemap', [PageController::class, 'sitemapPage'])->name('sitemap.page');
});

Route::middleware('throttle:forms')->group(function () {
    Route::post('/tours', [LeadFormController::class, 'storeTour'])->name('tours.store');
    Route::post('/trade', [LeadFormController::class, 'storeTrade'])->name('trade.store');
    Route::post('/careers/apply', [LeadFormController::class, 'storeApplication'])->name('careers.store');
    Route::post('/contact', [LeadFormController::class, 'storeEnquiry'])->name('contact.store');
});

// Addresses from the old clarkescourtrum.com, so links in guidebooks, cruise sites and search results keep working.
foreach ((array) config('gdl.legacy_redirects', []) as $old => $new) {
    Route::permanentRedirect($old, $new);
}

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'show'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:login');
});
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

Route::middleware(['auth', 'active'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', Admin\DashboardController::class)->name('dashboard');

    Route::get('/requests', [Admin\LeadController::class, 'index'])->name('leads.index');
    Route::get('/requests/export', [Admin\LeadController::class, 'export'])->name('leads.export');
    Route::get('/requests/{lead}', [Admin\LeadController::class, 'show'])->name('leads.show');
    Route::patch('/requests/{lead}', [Admin\LeadController::class, 'update'])->name('leads.update');
    Route::post('/requests/{lead}/notes', [Admin\LeadController::class, 'note'])->name('leads.note');
    Route::get('/requests/{lead}/files/{file}', [Admin\LeadController::class, 'file'])->name('leads.file');

    Route::middleware('role:admin,tours')->get('/tours', Admin\TourCalendarController::class)->name('tours.index');

    Route::middleware('role:admin,hr')->group(function () {
        Route::resource('vacancies', Admin\JobPostingController::class)->except('show')->parameters(['vacancies' => 'job']);
    });

    Route::middleware('role:admin')->group(function () {
        Route::get('/settings', [Admin\SettingsController::class, 'edit'])->name('settings.edit');
        Route::put('/settings', [Admin\SettingsController::class, 'update'])->name('settings.update');
        Route::get('/users', [Admin\UserController::class, 'index'])->name('users.index');
        Route::post('/users', [Admin\UserController::class, 'store'])->name('users.store');
        Route::patch('/users/{user}', [Admin\UserController::class, 'update'])->name('users.update');
    });
});
