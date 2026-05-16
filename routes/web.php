<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\Admin\BlogController as AdminBlogController;
use App\Http\Controllers\Admin\ReviewController as AdminReviewController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\LocationController as AdminLocationController;
use App\Http\Controllers\Admin\LocationVehiclePriceController as AdminLocationVehiclePriceController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\SocialMediaController;
use App\Http\Controllers\Admin\AboutController as AdminAboutController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\PayHereController;
use App\Http\Controllers\MyBookingsController;
use App\Http\Controllers\SearchController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/packages', [HomeController::class, 'packages'])->name('packages');
Route::get('/package/{slug}', [HomeController::class, 'packageDetails'])->name('package.details');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
Route::post('/contact', [\App\Http\Controllers\ContactController::class, 'store'])->name('contact.store');

// Price calculation API
Route::post('/api/calculate-price', [HomeController::class, 'calculatePrice'])->name('api.calculate-price');

// About Routes
Route::get('/about', [AboutController::class, 'index'])->name('about');

// Blog Routes
Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blog.show');
Route::get('/blog/category/{slug}', [BlogController::class, 'category'])->name('blog.category');
Route::get('/blog/search', [BlogController::class, 'search'])->name('blog.search');

// Booking Routes
Route::post('/bookings', [BookingController::class, 'store'])->name('bookings.store');

// User check API
Route::get('/api/check-user', [HomeController::class, 'checkUser'])->name('api.check-user');

// Vehicle Booking Routes
Route::prefix('vehicle-booking')->group(function () {
    Route::get('/vehicles', [App\Http\Controllers\VehicleBookingController::class, 'showVehicleResults'])->name('vehicle.booking.vehicles');
    Route::get('/calculate-price', [App\Http\Controllers\VehicleBookingController::class, 'calculatePrice'])->name('vehicle.booking.calculate-price');
    Route::post('/calculate-price', [App\Http\Controllers\VehicleBookingController::class, 'calculatePrice'])->name('vehicle.booking.calculate-price.post');
    Route::get('/calculate-all-prices', [App\Http\Controllers\VehicleBookingController::class, 'calculateAllVehiclePrices'])->name('vehicle.booking.calculate-all-prices');
    Route::post('/calculate-all-prices', [App\Http\Controllers\VehicleBookingController::class, 'calculateAllVehiclePrices'])->name('vehicle.booking.calculate-all-prices.post');
    Route::post('/create', [App\Http\Controllers\VehicleBookingController::class, 'createBooking'])->name('vehicle.booking.create');
    Route::post('/submit', [App\Http\Controllers\VehicleBookingController::class, 'submit'])->name('vehicle.booking.submit');
    Route::get('/details/{bookingId}', [App\Http\Controllers\VehicleBookingController::class, 'getBookingDetails'])->name('vehicle.booking.details');
});

// PayHere Payment Routes
Route::get('/payhere/initialize', [PayHereController::class, 'initializePayment'])->name('payhere.initialize');
Route::match(['get', 'post'], '/payhere/return', [PayHereController::class, 'handleReturn'])->name('payhere.return');
Route::match(['get', 'post'], '/payhere/cancel', [PayHereController::class, 'handleCancel'])->name('payhere.cancel');
Route::post('/payhere/notify', [PayHereController::class, 'handleNotify'])->name('payhere.notify');
Route::get('/booking/{bookingId}/success', [PayHereController::class, 'showSuccess'])->name('booking.success');
Route::get('/booking/{bookingId}/failed', [PayHereController::class, 'showFailed'])->name('booking.failed');
Route::get('/booking/{bookingId}/receipt', [PayHereController::class, 'printReceipt'])->name('booking.receipt');

// My Bookings Routes (User Panel)
Route::middleware('auth')->group(function () {
    Route::get('/my-bookings', [MyBookingsController::class, 'index'])->name('my-bookings.index');
    Route::get('/my-bookings/{booking}', [MyBookingsController::class, 'show'])->name('my-bookings.show');
    Route::get('/my-bookings/{booking}/edit', [MyBookingsController::class, 'edit'])->name('my-bookings.edit');
    Route::put('/my-bookings/{booking}', [MyBookingsController::class, 'update'])->name('my-bookings.update');
    Route::delete('/my-bookings/{booking}/cancel', [MyBookingsController::class, 'cancel'])->name('my-bookings.cancel');
    Route::get('/my-bookings-stats', [MyBookingsController::class, 'stats'])->name('my-bookings.stats');
});

// Search Routes
Route::get('/search', [SearchController::class, 'results'])->name('search.results');
Route::get('/api/search', [SearchController::class, 'search'])->name('search.api');

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Admin Routes
Route::prefix('admin')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    
    // Package Management
    Route::get('/packages', [AdminController::class, 'packages'])->name('admin.packages');
    Route::get('/packages/create', [AdminController::class, 'createPackage'])->name('admin.packages.create');
    Route::post('/packages', [AdminController::class, 'storePackage'])->name('admin.packages.store');
    Route::get('/packages/{package}/edit', [AdminController::class, 'editPackage'])->name('admin.packages.edit');
    Route::put('/packages/{package}', [AdminController::class, 'updatePackage'])->name('admin.packages.update');
    Route::delete('/packages/{package}', [AdminController::class, 'deletePackage'])->name('admin.packages.delete');
    
    // Category Management
    Route::get('/categories', [AdminController::class, 'categories'])->name('admin.categories');
    Route::get('/categories/create', [AdminController::class, 'createCategory'])->name('admin.categories.create');
    Route::post('/categories', [AdminController::class, 'storeCategory'])->name('admin.categories.store');
    Route::get('/categories/{category}/edit', [AdminController::class, 'editCategory'])->name('admin.categories.edit');
    Route::put('/categories/{category}', [AdminController::class, 'updateCategory'])->name('admin.categories.update');
    Route::delete('/categories/{category}', [AdminController::class, 'deleteCategory'])->name('admin.categories.delete');
    
    // Media Management
    Route::get('/media', [MediaController::class, 'index'])->name('admin.media');
    Route::post('/media', [MediaController::class, 'store'])->name('admin.media.store');
    Route::get('/media/selection', [MediaController::class, 'getForSelection'])->name('admin.media.selection');
    Route::get('/media/folders', [MediaController::class, 'getFolders'])->name('admin.media.folders');
    Route::get('/media/{media}', [MediaController::class, 'show'])->name('admin.media.show');
    Route::put('/media/{media}', [MediaController::class, 'update'])->name('admin.media.update');
    Route::delete('/media/{media}', [MediaController::class, 'destroy'])->name('admin.media.delete');
    
    // Blog Management
    Route::get('/blog', [AdminBlogController::class, 'index'])->name('admin.blog.index');
    Route::get('/blog/create', [AdminBlogController::class, 'create'])->name('admin.blog.create');
    Route::post('/blog/generate-article', [AdminBlogController::class, 'generateArticle'])->name('admin.blog.generate-article');
    Route::post('/blog', [AdminBlogController::class, 'store'])->name('admin.blog.store');
    Route::get('/blog/{blog}/edit', [AdminBlogController::class, 'edit'])->name('admin.blog.edit');
    Route::put('/blog/{blog}', [AdminBlogController::class, 'update'])->name('admin.blog.update');
    Route::delete('/blog/{blog}', [AdminBlogController::class, 'destroy'])->name('admin.blog.destroy');
    
    // Review Management
    Route::get('/reviews', [AdminReviewController::class, 'index'])->name('admin.reviews.index');
    Route::get('/reviews/create', [AdminReviewController::class, 'create'])->name('admin.reviews.create');
    Route::post('/reviews', [AdminReviewController::class, 'store'])->name('admin.reviews.store');
    Route::get('/reviews/{review}', [AdminReviewController::class, 'show'])->name('admin.reviews.show');
    Route::get('/reviews/{review}/edit', [AdminReviewController::class, 'edit'])->name('admin.reviews.edit');
    Route::put('/reviews/{review}', [AdminReviewController::class, 'update'])->name('admin.reviews.update');
    Route::delete('/reviews/{review}', [AdminReviewController::class, 'destroy'])->name('admin.reviews.destroy');
    Route::patch('/reviews/{review}/toggle-approval', [AdminReviewController::class, 'toggleApproval'])->name('admin.reviews.toggle-approval');
    Route::patch('/reviews/{review}/toggle-featured', [AdminReviewController::class, 'toggleFeatured'])->name('admin.reviews.toggle-featured');
    
    // Social media links (homepage sidebar)
    Route::get('/social-media', [SocialMediaController::class, 'index'])->name('admin.social-media.index');
    Route::put('/social-media', [SocialMediaController::class, 'update'])->name('admin.social-media.update');

    // Settings Management
    Route::get('/settings', [SettingsController::class, 'index'])->name('admin.settings.index');
    Route::put('/settings', [SettingsController::class, 'update'])->name('admin.settings.update');
    Route::get('/settings/create', [SettingsController::class, 'create'])->name('admin.settings.create');
    Route::post('/settings', [SettingsController::class, 'store'])->name('admin.settings.store');
    Route::get('/settings/{setting}/edit', [SettingsController::class, 'edit'])->name('admin.settings.edit');
    Route::put('/settings/{setting}', [SettingsController::class, 'updateSetting'])->name('admin.settings.update-setting');
    Route::delete('/settings/{setting}', [SettingsController::class, 'destroy'])->name('admin.settings.destroy');
    
    // About Page Management (Single Page)
    Route::get('/about', [AdminAboutController::class, 'index'])->name('admin.about.index');
    Route::get('/about/create', [AdminAboutController::class, 'create'])->name('admin.about.create');
    Route::post('/about', [AdminAboutController::class, 'store'])->name('admin.about.store');
    Route::get('/about/edit', [AdminAboutController::class, 'edit'])->name('admin.about.edit');
    Route::put('/about', [AdminAboutController::class, 'update'])->name('admin.about.update');
    Route::delete('/about', [AdminAboutController::class, 'destroy'])->name('admin.about.destroy');
    
    // Booking Management
    Route::get('/bookings', [AdminController::class, 'bookings'])->name('admin.bookings');
    Route::get('/bookings/{booking}', [AdminController::class, 'showBooking'])->name('admin.bookings.show');
    Route::patch('/bookings/{booking}/status', [AdminController::class, 'updateBookingStatus'])->name('admin.bookings.update-status');
    Route::put('/bookings/{booking}', [AdminController::class, 'updateBooking'])->name('admin.bookings.update');
    
    // User Management
    Route::resource('users', AdminUserController::class)->names([
        'index' => 'admin.users.index',
        'create' => 'admin.users.create',
        'store' => 'admin.users.store',
        'show' => 'admin.users.show',
        'edit' => 'admin.users.edit',
        'update' => 'admin.users.update',
        'destroy' => 'admin.users.destroy',
    ]);
    Route::patch('/users/{user}/toggle-status', [AdminUserController::class, 'toggleStatus'])->name('admin.users.toggle-status');
    
    // Vehicle Management
    Route::resource('vehicles', \App\Http\Controllers\Admin\VehicleController::class)->names([
        'index' => 'admin.vehicles.index',
        'create' => 'admin.vehicles.create',
        'store' => 'admin.vehicles.store',
        'show' => 'admin.vehicles.show',
        'edit' => 'admin.vehicles.edit',
        'update' => 'admin.vehicles.update',
        'destroy' => 'admin.vehicles.destroy',
    ]);
    Route::patch('/vehicles/{vehicle}/toggle-status', [\App\Http\Controllers\Admin\VehicleController::class, 'toggleStatus'])->name('admin.vehicles.toggle-status');
    Route::patch('/vehicles/{vehicle}/update-status', [\App\Http\Controllers\Admin\VehicleController::class, 'updateStatus'])->name('admin.vehicles.update-status');
    
    // Location Management
    Route::resource('locations', AdminLocationController::class)->names([
        'index' => 'admin.locations.index',
        'create' => 'admin.locations.create',
        'store' => 'admin.locations.store',
        'show' => 'admin.locations.show',
        'edit' => 'admin.locations.edit',
        'update' => 'admin.locations.update',
        'destroy' => 'admin.locations.destroy',
    ]);
    Route::patch('/locations/{location}/toggle-status', [AdminLocationController::class, 'toggleStatus'])->name('admin.locations.toggle-status');
    
    // Location-Vehicle Price Management
    Route::resource('location-vehicle-prices', AdminLocationVehiclePriceController::class)->names([
        'index' => 'admin.location-vehicle-prices.index',
        'create' => 'admin.location-vehicle-prices.create',
        'store' => 'admin.location-vehicle-prices.store',
        'show' => 'admin.location-vehicle-prices.show',
        'edit' => 'admin.location-vehicle-prices.edit',
        'update' => 'admin.location-vehicle-prices.update',
        'destroy' => 'admin.location-vehicle-prices.destroy',
    ]);
    Route::patch('/location-vehicle-prices/{locationVehiclePrice}/toggle-status', [AdminLocationVehiclePriceController::class, 'toggleStatus'])->name('admin.location-vehicle-prices.toggle-status');

    // Startup promo popup
    Route::get('/promo-popup', [\App\Http\Controllers\Admin\PromoPopupController::class, 'index'])->name('admin.promo-popup.index');
    Route::get('/promo-popup/create', [\App\Http\Controllers\Admin\PromoPopupController::class, 'create'])->name('admin.promo-popup.create');
    Route::post('/promo-popup', [\App\Http\Controllers\Admin\PromoPopupController::class, 'store'])->name('admin.promo-popup.store');
    Route::post('/promo-popup/generate-banner', [\App\Http\Controllers\Admin\PromoPopupController::class, 'generateBanner'])->name('admin.promo-popup.generate-banner');
    Route::put('/promo-popup/settings', [\App\Http\Controllers\Admin\PromoPopupController::class, 'updateSettings'])->name('admin.promo-popup.settings');
    Route::get('/promo-popup/{slide}/edit', [\App\Http\Controllers\Admin\PromoPopupController::class, 'edit'])->name('admin.promo-popup.edit');
    Route::put('/promo-popup/{slide}', [\App\Http\Controllers\Admin\PromoPopupController::class, 'update'])->name('admin.promo-popup.update');
    Route::delete('/promo-popup/{slide}', [\App\Http\Controllers\Admin\PromoPopupController::class, 'destroy'])->name('admin.promo-popup.destroy');
    Route::patch('/promo-popup/{slide}/toggle-status', [\App\Http\Controllers\Admin\PromoPopupController::class, 'toggleStatus'])->name('admin.promo-popup.toggle-status');
});
