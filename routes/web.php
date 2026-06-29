<?php

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\AgentDashboardController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmailVerificationController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\EnquiryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\TestimonialController;
use Illuminate\Support\Facades\Route;

// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/contact', [ContactController::class, 'create'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

// Authentication Routes
Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
Route::post('/login', [AuthenticatedSessionController::class, 'store']);
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
Route::post('/register', [RegisteredUserController::class, 'store'])->name('register.store');

// Email Verification Routes
Route::get('/email/verify', [EmailVerificationController::class, 'notice'])->name('verification.notice');
Route::get('/email/verify/code', [EmailVerificationController::class, 'showCodeForm'])->name('verification.code');
Route::post('/email/verify/code', [EmailVerificationController::class, 'verifyWithCode'])->name('verification.verify.code');
Route::get('/email/verify/{token}', [EmailVerificationController::class, 'verify'])->name('verification.verify');
Route::get('/email/verify/success', [EmailVerificationController::class, 'success'])->name('verification.success');
Route::post('/email/verify/resend', [EmailVerificationController::class, 'resend'])->name('verification.resend');
Route::post('/email/verify/resend-login', [EmailVerificationController::class, 'resendFromLogin'])->name('verification.resend.login');

// Password Reset Routes
Route::get('/password/reset', [PasswordResetController::class, 'showRequestForm'])->name('password.request');
Route::post('/password/reset', [PasswordResetController::class, 'sendResetLink'])->name('password.email');
Route::get('/password/reset/{token}', [PasswordResetController::class, 'showResetForm'])->name('password.reset');
Route::post('/password/reset/confirm', [PasswordResetController::class, 'resetPassword'])->name('password.update');

// Public Package Routes
Route::get('/packages', [PackageController::class, 'index'])->name('packages.index');
Route::get('/packages/{slug}', [PackageController::class, 'show'])->name('packages.show');

// Public Gallery Route
Route::get('/gallery', [GalleryController::class, 'index'])->name('gallery.index');

// Admin Package Management (separate from main admin group)
Route::middleware(['role:super_admin|admin|sales_agent'])->prefix('admin/packages')->name('admin.packages.')->group(function () {
    Route::get('/', [PackageController::class, 'adminIndex'])->name('index');
    Route::get('/create', [PackageController::class, 'create'])->name('create');
    Route::post('/', [PackageController::class, 'store'])->name('store');
    Route::get('/{package}/edit', [PackageController::class, 'edit'])->name('edit');
    Route::put('/{package}', [PackageController::class, 'update'])->name('update');
    Route::delete('/{package}', [PackageController::class, 'destroy'])->name('destroy');
    Route::post('/{package}/toggle-featured', [PackageController::class, 'toggleFeatured'])->name('toggle-featured');
    Route::post('/{package}/toggle-published', [PackageController::class, 'togglePublished'])->name('toggle-published');
});

// Customer Enquiry Routes (outside admin group)
Route::middleware(['auth', 'role:customer', 'verified'])->group(function () {
    Route::get('/enquiry', [EnquiryController::class, 'create'])->name('enquiry.create');
    Route::post('/enquiry', [EnquiryController::class, 'store'])->name('enquiry.store');
    Route::get('/enquiry/thank-you', [EnquiryController::class, 'thankYou'])->name('enquiry.thank-you');
});

// Admin Enquiry Management Routes (inside admin group with different path)
Route::middleware(['role:super_admin|admin|sales_agent'])->prefix('admin/enquiries')->name('admin.enquiries.')->group(function () {
    Route::get('/', [EnquiryController::class, 'adminIndex'])->name('index');
    Route::get('/{enquiry}', [EnquiryController::class, 'show'])->name('show');
    Route::post('/{enquiry}/assign', [EnquiryController::class, 'assign'])->name('assign');
    Route::post('/{enquiry}/status', [EnquiryController::class, 'updateStatus'])->name('status');
    Route::post('/{enquiry}/approve', [EnquiryController::class, 'approve'])->name('approve');
    Route::post('/{enquiry}/reject', [EnquiryController::class, 'reject'])->name('reject');
    Route::post('/{enquiry}/note', [EnquiryController::class, 'addNote'])->name('note');
    Route::post('/{enquiry}/reminder', [EnquiryController::class, 'setReminder'])->name('reminder');
    Route::delete('/{enquiry}', [EnquiryController::class, 'destroy'])->name('destroy');
});

// Admin Contact Management Routes
Route::middleware(['role:super_admin|admin|sales_agent'])->prefix('admin/contacts')->name('admin.contacts.')->group(function () {
    Route::get('/', [ContactController::class, 'adminIndex'])->name('index');
    Route::get('/{contact}', [ContactController::class, 'show'])->name('show');
    Route::post('/{contact}/status', [ContactController::class, 'updateStatus'])->name('status');
    Route::post('/{contact}/mark-replied', [ContactController::class, 'markAsReplied'])->name('mark-replied');
    Route::post('/{contact}/mark-closed', [ContactController::class, 'markAsClosed'])->name('mark-closed');
    Route::delete('/{contact}', [ContactController::class, 'destroy'])->name('destroy');
});

// Admin Gallery Management Routes
Route::middleware(['role:super_admin|admin|sales_agent'])->prefix('admin/gallery')->name('admin.gallery.')->group(function () {
    Route::get('/', [GalleryController::class, 'adminIndex'])->name('index');
    Route::get('/create', [GalleryController::class, 'create'])->name('create');
    Route::post('/', [GalleryController::class, 'store'])->name('store');
    Route::get('/{gallery}/edit', [GalleryController::class, 'edit'])->name('edit');
    Route::put('/{gallery}', [GalleryController::class, 'update'])->name('update');
    Route::delete('/{gallery}', [GalleryController::class, 'destroy'])->name('destroy');
    Route::post('/{gallery}/toggle-active', [GalleryController::class, 'toggleActive'])->name('toggle-active');
});

// Admin Testimonials Management Routes
Route::middleware(['role:super_admin|admin|sales_agent'])->prefix('admin/testimonials')->name('admin.testimonials.')->group(function () {
    Route::get('/', [TestimonialController::class, 'adminIndex'])->name('index');
    Route::get('/create', [TestimonialController::class, 'create'])->name('create');
    Route::post('/', [TestimonialController::class, 'store'])->name('store');
    Route::get('/{testimonial}/edit', [TestimonialController::class, 'edit'])->name('edit');
    Route::put('/{testimonial}', [TestimonialController::class, 'update'])->name('update');
    Route::delete('/{testimonial}', [TestimonialController::class, 'destroy'])->name('destroy');
    Route::post('/{testimonial}/toggle-approved', [TestimonialController::class, 'toggleApproved'])->name('toggle-approved');
    Route::post('/{testimonial}/toggle-featured', [TestimonialController::class, 'toggleFeatured'])->name('toggle-featured');
});

// Protected Routes
Route::middleware(['auth'])->group(function () {
    // User Dashboard (customers must be verified)
    Route::middleware(['verified'])->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::post('/dashboard/profile', [DashboardController::class, 'updateProfile'])->name('dashboard.update-profile');
    });

    // Admin Routes
    Route::middleware(['role:super_admin|admin|sales_agent'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');

        // Agent Dashboard (sales agents only)
        Route::middleware(['role:sales_agent'])->group(function () {
            Route::get('/agent-dashboard', [AgentDashboardController::class, 'index'])->name('agent.dashboard');
        });

        // User Management (super_admin and admin only)
        Route::middleware(['role:super_admin|admin'])->group(function () {
            Route::resource('users', UserController::class);
            Route::post('users/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('users.toggle-status');
            Route::get('agents', [UserController::class, 'agents'])->name('users.agents');
        });
    });
});