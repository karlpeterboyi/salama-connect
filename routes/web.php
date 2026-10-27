<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\FacilityController;
use App\Http\Controllers\ProgramController;
use App\Http\Controllers\SupportRequestController;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\VolunteerController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProgramController as AdminProgramController;
use App\Http\Controllers\Admin\ChildController as AdminChildController;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/find-support', [FacilityController::class, 'index'])->name('facilities.index');
Route::get('/find-support/{slug}', [FacilityController::class, 'show'])->name('facilities.show');

Route::get('/programs', [ProgramController::class, 'index'])->name('programs.index');
Route::get('/programs/{slug}', [ProgramController::class, 'show'])->name('programs.show');

Route::get('/request-help', [SupportRequestController::class, 'create'])->name('support.create');
Route::post('/request-help', [SupportRequestController::class, 'store'])->name('support.store');
Route::get('/request-help/thanks/{reference}', [SupportRequestController::class, 'thanks'])->name('support.thanks');

Route::get('/donate', [DonationController::class, 'create'])->name('donate.create');
Route::post('/donate', [DonationController::class, 'store'])->name('donate.store');
Route::get('/donate/pesapal/callback', [DonationController::class, 'pesapalCallback'])->name('donate.pesapal.callback');
Route::match(['get', 'post'], '/donate/pesapal/ipn', [DonationController::class, 'pesapalIpn'])->name('donate.pesapal.ipn');

Route::get('/volunteer', [VolunteerController::class, 'create'])->name('volunteer.create');
Route::post('/volunteer', [VolunteerController::class, 'store'])->name('volunteer.store');

Route::view('/about', 'pages.about')->name('about');
Route::view('/contact', 'pages.contact')->name('contact');
Route::view('/privacy', 'pages.privacy')->name('privacy');

Route::get('/lang/{locale}', function (string $locale) {
    if (in_array($locale, ['en', 'sw'])) {
        session(['locale' => $locale]);
        app()->setLocale($locale);
    }
    return redirect()->back();
})->name('lang.switch');

// Admin (add auth middleware in production)
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('programs', AdminProgramController::class)->except(['show']);
    Route::resource('children', AdminChildController::class)->except(['show']);
});
