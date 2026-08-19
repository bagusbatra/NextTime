<?php

use App\Http\Controllers\Admin\ClientController;
use App\Http\Controllers\Admin\ContactMessageController;
use App\Http\Controllers\Admin\ContactSettingsController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\GalleryItemController;
use App\Http\Controllers\Admin\HeroSlideController;
use App\Http\Controllers\Admin\PricingPackageController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\SiteSettingsController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\WaWidgetSettingsController;
use App\Http\Controllers\Admin\WhyUsItemController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->name('admin.')->middleware(['auth', 'verified', 'admin'])->group(function () {
    Route::get('/dashboard', DashboardController::class)->name('dashboard');
    Route::resource('users', UserController::class)->except(['show']);

    Route::patch('projects/{project}/toggle-featured', [ProjectController::class, 'toggleFeatured'])->name('projects.toggle-featured');
    Route::resource('projects', ProjectController::class)->except(['show']);

    Route::patch('hero-slides/{heroSlide}/toggle', [HeroSlideController::class, 'toggle'])->name('hero-slides.toggle');
    Route::resource('hero-slides', HeroSlideController::class)->except(['show']);

    Route::patch('services/{service}/toggle', [ServiceController::class, 'toggle'])->name('services.toggle');
    Route::resource('services', ServiceController::class)->except(['show']);

    Route::patch('pricing-packages/{pricingPackage}/toggle', [PricingPackageController::class, 'toggle'])->name('pricing-packages.toggle');
    Route::resource('pricing-packages', PricingPackageController::class)->except(['show']);

    Route::patch('why-us-items/{whyUsItem}/toggle', [WhyUsItemController::class, 'toggle'])->name('why-us-items.toggle');
    Route::put('why-us-items-settings', [WhyUsItemController::class, 'updateSettings'])->name('why-us-items.settings');
    Route::resource('why-us-items', WhyUsItemController::class)->except(['show']);

    Route::patch('clients/{client}/toggle', [ClientController::class, 'toggle'])->name('clients.toggle');
    Route::resource('clients', ClientController::class)->except(['show']);

    Route::patch('gallery-items/{galleryItem}/toggle', [GalleryItemController::class, 'toggle'])->name('gallery-items.toggle');
    Route::resource('gallery-items', GalleryItemController::class)->except(['show']);

    Route::get('contact-settings', [ContactSettingsController::class, 'edit'])->name('contact-settings.edit');
    Route::put('contact-settings', [ContactSettingsController::class, 'update'])->name('contact-settings.update');

    Route::patch('contact-messages/{contactMessage}/status', [ContactMessageController::class, 'updateStatus'])->name('contact-messages.status');
    Route::resource('contact-messages', ContactMessageController::class)->only(['index', 'show', 'destroy']);

    Route::get('wa-widget-settings', [WaWidgetSettingsController::class, 'edit'])->name('wa-widget-settings.edit');
    Route::put('wa-widget-settings', [WaWidgetSettingsController::class, 'update'])->name('wa-widget-settings.update');

    Route::get('settings', [SiteSettingsController::class, 'edit'])->name('settings.edit');
    Route::put('settings/branding', [SiteSettingsController::class, 'updateBranding'])->name('settings.branding');
    Route::put('settings/sections', [SiteSettingsController::class, 'updateSections'])->name('settings.sections');
});
