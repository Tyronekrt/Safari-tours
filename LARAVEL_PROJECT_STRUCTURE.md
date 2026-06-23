# Safari Tour Management System - Laravel Project Structure & Architecture

## 1. Project Directory Structure

```
safari-tour-management/
├── app/
│   ├── Actions/
│   │   ├── Fortify/
│   │   │   ├── AttemptToAuthenticate.php
│   │   │   ├── CreateNewUser.php
│   │   │   ├── ResetUserPassword.php
│   │   │   └── UpdateUserProfileInformation.php
│   ├── Console/
│   │   ├── Commands/
│   │   │   ├── SendFollowUpReminders.php
│   │   │   ├── CleanupOldEnquiries.php
│   │   │   └── GenerateMonthlyReports.php
│   │   └── Kernel.php
│   ├── Events/
│   │   ├── EnquiryCreated.php
│   │   ├── EnquiryStatusChanged.php
│   │   ├── EnquiryAssigned.php
│   │   ├── PackagePublished.php
│   │   └── UserRegistered.php
│   ├── Exceptions/
│   │   └── Handler.php
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Api/
│   │   │   │   ├── V1/
│   │   │   │   │   ├── AuthController.php
│   │   │   │   │   ├── EnquiryController.php
│   │   │   │   │   ├── PackageController.php
│   │   │   │   │   ├── DestinationController.php
│   │   │   │   │   ├── BlogController.php
│   │   │   │   │   ├── UserController.php
│   │   │   │   │   └── DashboardController.php
│   │   │   ├── Admin/
│   │   │   │   ├── DashboardController.php
│   │   │   │   ├── UserController.php
│   │   │   │   ├── EnquiryController.php
│   │   │   │   ├── PackageController.php
│   │   │   │   ├── DestinationController.php
│   │   │   │   ├── BlogController.php
│   │   │   │   ├── TestimonialController.php
│   │   │   │   ├── HomepageController.php
│   │   │   │   └── SettingsController.php
│   │   │   ├── Sales/
│   │   │   │   ├── DashboardController.php
│   │   │   │   ├── EnquiryController.php
│   │   │   │   └── ReportController.php
│   │   │   ├── Frontend/
│   │   │   │   ├── HomeController.php
│   │   │   │   ├── PackageController.php
│   │   │   │   ├── DestinationController.php
│   │   │   │   ├── BlogController.php
│   │   │   │   ├── ContactController.php
│   │   │   │   └── EnquiryController.php
│   │   │   ├── Auth/
│   │   │   │   ├── AuthenticatedSessionController.php
│   │   │   │   ├── ConfirmablePasswordController.php
│   │   │   │   ├── EmailVerificationNotificationController.php
│   │   │   │   ├── EmailVerificationPromptController.php
│   │   │   │   ├── NewPasswordController.php
│   │   │   │   ├── PasswordController.php
│   │   │   │   ├── PasswordResetLinkController.php
│   │   │   │   ├── RegisteredUserController.php
│   │   │   │   └── VerifyEmailController.php
│   │   │   └── Controller.php
│   │   ├── Middleware/
│   │   │   ├── Authenticate.php
│   │   │   ├── EncryptCookies.php
│   │   │   ├── PreventRequestsDuringMaintenance.php
│   │   │   ├── RedirectIfAuthenticated.php
│   │   │   ├── TrimStrings.php
│   │   │   ├── TrustHosts.php
│   │   │   ├── TrustProxies.php
│   │   │   ├── ValidateSignature.php
│   │   │   ├── CheckRole.php
│   │   │   ├── CheckPermission.php
│   │   │   ├── LogUserActivity.php
│   │   │   └── SetLocale.php
│   │   ├── Requests/
│   │   │   ├── Auth/
│   │   │   │   ├── LoginRequest.php
│   │   │   │   └── RegisterRequest.php
│   │   │   ├── Enquiry/
│   │   │   │   ├── StoreEnquiryRequest.php
│   │   │   │   ├── UpdateEnquiryRequest.php
│   │   │   │   └── AssignEnquiryRequest.php
│   │   │   ├── Package/
│   │   │   │   ├── StorePackageRequest.php
│   │   │   │   └── UpdatePackageRequest.php
│   │   │   ├── Blog/
│   │   │   │   ├── StoreBlogPostRequest.php
│   │   │   │   └── UpdateBlogPostRequest.php
│   │   │   └── Request.php
│   │   ├── Resources/
│   │   │   ├── UserResource.php
│   │   │   ├── EnquiryResource.php
│   │   │   ├── PackageResource.php
│   │   │   ├── DestinationResource.php
│   │   │   ├── BlogPostResource.php
│   │   │   └── TestimonialResource.php
│   │   └── Kernel.php
│   ├── Jobs/
│   │   ├── SendEnquiryConfirmationEmail.php
│   │   ├── SendEnquiryAssignmentNotification.php
│   │   ├── SendStatusChangeNotification.php
│   │   ├── SendFollowUpReminderEmail.php
│   │   ├── ProcessEnquiryExport.php
│   │   └── GenerateReport.php
│   ├── Listeners/
│   │   ├── SendEnquiryConfirmation.php
│   │   ├── NotifySalesAgent.php
│   │   ├── LogEnquiryStatusChange.php
│   │   ├── IndexPackageForSearch.php
│   │   └── SendWelcomeEmail.php
│   ├── Models/
│   │   ├── User.php
│   │   ├── Enquiry.php
│   │   ├── EnquiryNote.php
│   │   ├── EnquiryStatusHistory.php
│   │   ├── FollowUpReminder.php
│   │   ├── SafariPackage.php
│   │   ├── PackageCategory.php
│   │   ├── PackageGallery.php
│   │   ├── Destination.php
│   │   ├── BlogPost.php
│   │   ├── BlogCategory.php
│   │   ├── BlogTag.php
│   │   ├── BlogComment.php
│   │   ├── Testimonial.php
│   │   ├── HomepageSection.php
│   │   ├── NewsletterSubscriber.php
│   │   ├── ActivityLog.php
│   │   └── Setting.php
│   ├── Notifications/
│   │   ├── EnquiryConfirmation.php
│   │   ├── EnquiryAssigned.php
│   │   ├── EnquiryStatusChanged.php
│   │   ├── FollowUpReminder.php
│   │   └── PasswordReset.php
│   ├── Policies/
│   │   ├── EnquiryPolicy.php
│   │   ├── PackagePolicy.php
│   │   ├── BlogPostPolicy.php
│   │   ├── UserPolicy.php
│   │   └── DestinationPolicy.php
│   ├── Providers/
│   │   ├── AppServiceProvider.php
│   │   ├── AuthServiceProvider.php
│   │   ├── EventServiceProvider.php
│   │   └── RouteServiceProvider.php
│   ├── Repositories/
│   │   ├── Interfaces/
│   │   │   ├── EnquiryRepositoryInterface.php
│   │   │   ├── PackageRepositoryInterface.php
│   │   │   ├── UserRepositoryInterface.php
│   │   │   └── DestinationRepositoryInterface.php
│   │   ├── EnquiryRepository.php
│   │   ├── PackageRepository.php
│   │   ├── UserRepository.php
│   │   └── DestinationRepository.php
│   ├── Services/
│   │   ├── EnquiryService.php
│   │   ├── PackageService.php
│   │   ├── UserService.php
│   │   ├── EmailService.php
│   │   ├── ExportService.php
│   │   ├── ReportService.php
│   │   ├── FileUploadService.php
│   │   └── SearchService.php
│   ├── Traits/
│   │   ├── HasPermissions.php
│   │   ├── HasActivityLog.php
│   │   └── Filterable.php
│   └── helpers.php
├── bootstrap/
│   └── app.php
├── config/
│   ├── app.php
│   ├── auth.php
│   ├── backup.php
│   ├── broadcasting.php
│   ├── cache.php
│   ├── cors.php
│   ├── database.php
│   ├── filesystems.php
│   ├── logging.php
│   ├── mail.php
│   ├── permission.php
│   ├── queue.php
│   ├── sanctum.php
│   ├── scout.php
│   ├── services.php
│   ├── session.php
│   └── view.php
├── database/
│   ├── factories/
│   │   ├── UserFactory.php
│   │   ├── EnquiryFactory.php
│   │   ├── PackageFactory.php
│   │   ├── DestinationFactory.php
│   │   └── BlogPostFactory.php
│   ├── migrations/
│   │   ├── 2024_01_01_000000_create_users_table.php
│   │   ├── 2024_01_01_000001_create_permission_tables.php
│   │   ├── 2024_01_01_000002_create_activity_logs_table.php
│   │   ├── 2024_01_01_000003_create_package_categories_table.php
│   │   ├── 2024_01_01_000004_create_safari_packages_table.php
│   │   ├── 2024_01_01_000005_create_destinations_table.php
│   │   ├── 2024_01_01_000006_create_package_destination_table.php
│   │   ├── 2024_01_01_000007_create_package_gallery_table.php
│   │   ├── 2024_01_01_000008_create_blog_categories_table.php
│   │   ├── 2024_01_01_000009_create_blog_tags_table.php
│   │   ├── 2024_01_01_000010_create_blog_posts_table.php
│   │   ├── 2024_01_01_000011_create_blog_post_tag_table.php
│   │   ├── 2024_01_01_000012_create_blog_comments_table.php
│   │   ├── 2024_01_01_000013_create_enquiries_table.php
│   │   ├── 2024_01_01_000014_create_enquiry_notes_table.php
│   │   ├── 2024_01_01_000015_create_enquiry_status_history_table.php
│   │   ├── 2024_01_01_000016_create_follow_up_reminders_table.php
│   │   ├── 2024_01_01_000017_create_testimonials_table.php
│   │   ├── 2024_01_01_000018_create_homepage_sections_table.php
│   │   ├── 2024_01_01_000019_create_newsletter_subscribers_table.php
│   │   └── 2024_01_01_000020_create_settings_table.php
│   └── seeders/
│       ├── DatabaseSeeder.php
│       ├── RolePermissionSeeder.php
│       ├── SettingsSeeder.php
│       ├── PackageCategorySeeder.php
│       ├── UserSeeder.php
│       └── PackageSeeder.php
├── public/
│   ├── css/
│   ├── js/
│   ├── images/
│   ├── storage/
│   └── index.php
├── resources/
│   ├── css/
│   │   └── app.css
│   ├── js/
│   │   └── app.js
│   ├── lang/
│   │   └── en/
│   │       ├── auth.php
│   │       ├── pagination.php
│   │       ├── passwords.php
│   │       └── validation.php
│   ├── views/
│   │   ├── layouts/
│   │   │   ├── app.blade.php
│   │   │   ├── admin.blade.php
│   │   │   ├── frontend.blade.php
│   │   │   └── auth.blade.php
│   │   ├── components/
│   │   │   ├── navbar.blade.php
│   │   │   ├── footer.blade.php
│   │   │   ├── sidebar.blade.php
│   │   │   ├── package-card.blade.php
│   │   │   ├── destination-card.blade.php
│   │   │   └── testimonial-slider.blade.php
│   │   ├── auth/
│   │   │   ├── login.blade.php
│   │   │   ├── register.blade.php
│   │   │   ├── forgot-password.blade.php
│   │   │   └── reset-password.blade.php
│   │   ├── admin/
│   │   │   ├── dashboard.blade.php
│   │   │   ├── users/
│   │   │   │   ├── index.blade.php
│   │   │   │   ├── create.blade.php
│   │   │   │   ├── edit.blade.php
│   │   │   │   └── show.blade.php
│   │   │   ├── enquiries/
│   │   │   │   ├── index.blade.php
│   │   │   │   ├── create.blade.php
│   │   │   │   ├── edit.blade.php
│   │   │   │   └── show.blade.php
│   │   │   ├── packages/
│   │   │   │   ├── index.blade.php
│   │   │   │   ├── create.blade.php
│   │   │   │   ├── edit.blade.php
│   │   │   │   └── show.blade.php
│   │   │   ├── destinations/
│   │   │   │   ├── index.blade.php
│   │   │   │   ├── create.blade.php
│   │   │   │   ├── edit.blade.php
│   │   │   │   └── show.blade.php
│   │   │   ├── blog/
│   │   │   │   ├── index.blade.php
│   │   │   │   ├── create.blade.php
│   │   │   │   ├── edit.blade.php
│   │   │   │   └── show.blade.php
│   │   │   ├── testimonials/
│   │   │   │   ├── index.blade.php
│   │   │   │   ├── create.blade.php
│   │   │   │   └── edit.blade.php
│   │   │   ├── homepage/
│   │   │   │   └── edit.blade.php
│   │   │   └── settings/
│   │   │       └── edit.blade.php
│   │   ├── sales/
│   │   │   ├── dashboard.blade.php
│   │   │   ├── enquiries/
│   │   │   │   ├── index.blade.php
│   │   │   │   └── show.blade.php
│   │   │   └── reports/
│   │   │       └── index.blade.php
│   │   ├── frontend/
│   │   │   ├── home.blade.php
│   │   │   ├── about.blade.php
│   │   │   ├── packages/
│   │   │   │   ├── index.blade.php
│   │   │   │   └── show.blade.php
│   │   │   ├── destinations/
│   │   │   │   ├── index.blade.php
│   │   │   │   └── show.blade.php
│   │   │   ├── blog/
│   │   │   │   ├── index.blade.php
│   │   │   │   └── show.blade.php
│   │   │   ├── contact.blade.php
│   │   │   ├── enquiry.blade.php
│   │   │   └── testimonials.blade.php
│   │   ├── emails/
│   │   │   ├── enquiry-confirmation.blade.php
│   │   │   ├── enquiry-assigned.blade.php
│   │   │   ├── status-changed.blade.php
│   │   │   └── follow-up-reminder.blade.php
│   │   └── errors/
│   │       ├── 401.blade.php
│   │       ├── 403.blade.php
│   │       ├── 404.blade.php
│   │       ├── 500.blade.php
│   │       └── 503.blade.php
│   └── views.php
├── routes/
│   ├── api.php
│   ├── channels.php
│   ├── console.php
│   └── web.php
├── storage/
│   ├── app/
│   │   ├── public/
│   │   └── exports/
│   ├── framework/
│   │   ├── cache/
│   │   ├── sessions/
│   │   └── views/
│   └── logs/
├── tests/
│   ├── Feature/
│   │   ├── Auth/
│   │   │   ├── AuthenticationTest.php
│   │   │   ├── EmailVerificationTest.php
│   │   │   └── PasswordResetTest.php
│   │   ├── Enquiries/
│   │   │   ├── EnquiryManagementTest.php
│   │   │   └── EnquiryAPITest.php
│   │   ├── Packages/
│   │   │   ├── PackageManagementTest.php
│   │   │   └── PackageAPITest.php
│   │   ├── Blog/
│   │   │   ├── BlogManagementTest.php
│   │   │   └── BlogAPITest.php
│   │   └── Admin/
│   │       ├── DashboardTest.php
│   │       └── UserManagementTest.php
│   ├── Unit/
│   │   ├── Models/
│   │   │   ├── UserTest.php
│   │   │   ├── EnquiryTest.php
│   │   │   ├── PackageTest.php
│   │   │   └── DestinationTest.php
│   │   ├── Services/
│   │   │   ├── EnquiryServiceTest.php
│   │   │   ├── PackageServiceTest.php
│   │   │   └── EmailServiceTest.php
│   │   └── Repositories/
│   │       ├── EnquiryRepositoryTest.php
│   │       └── PackageRepositoryTest.php
│   └── TestCase.php
├── .env.example
├── .gitignore
├ ├── artisan
├ ├── composer.json
├ ├── package.json
├ ├── phpunit.xml
├ ├── README.md
└── vite.config.js
```

## 2. Architecture Patterns

### 2.1 MVC (Model-View-Controller)
The system follows the classic MVC pattern with Laravel's conventions:

- **Models**: Handle data logic and database interactions
- **Views**: Handle presentation layer using Blade templates
- **Controllers**: Handle HTTP requests and coordinate between Models and Views

### 2.2 Repository Pattern
Implementation of the Repository pattern for data access abstraction:

**Benefits**:
- Decouples application logic from data storage
- Easier unit testing with mock repositories
- Centralized data access logic
- Consistent data access patterns

### 2.3 Service Layer
Business logic encapsulation in service classes:

**Benefits**:
- Controllers remain thin
- Business logic reusable across different controllers
- Easier to test business logic independently
- Better code organization

### 2.4 Request/Response Pattern
Using Form Request classes for validation and API Resources for response transformation:

**Benefits**:
- Centralized validation logic
- Consistent API responses
- Type safety
- Auto-documentation friendly

## 3. Routing Structure

### 3.1 Web Routes (routes/web.php)

```php
<?php

use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\PackageController;
use App\Http\Controllers\Frontend\DestinationController;
use App\Http\Controllers\Frontend\BlogController;
use App\Http\Controllers\Frontend\ContactController;
use App\Http\Controllers\Frontend\EnquiryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\EnquiryController as AdminEnquiryController;
use App\Http\Controllers\Admin\PackageController as AdminPackageController;
use App\Http\Controllers\Admin\DestinationController as AdminDestinationController;
use App\Http\Controllers\Admin\BlogController as AdminBlogController;
use App\Http\Controllers\Sales\DashboardController as SalesDashboardController;
use Illuminate\Support\Facades\Route;

// Authentication Routes
require __DIR__.'/auth.php';

// Public/Frontend Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

// Enquiry Routes
Route::get('/enquiry', [EnquiryController::class, 'create'])->name('enquiry.create');
Route::post('/enquiry', [EnquiryController::class, 'store'])->name('enquiry.store');
Route::get('/enquiry/thank-you', [EnquiryController::class, 'thankYou'])->name('enquiry.thank-you');

// Newsletter
Route::post('/newsletter/subscribe', [HomeController::class, 'subscribeNewsletter'])->name('newsletter.subscribe');

// Safari Packages
Route::prefix('safaris')->group(function () {
    Route::get('/', [PackageController::class, 'index'])->name('packages.index');
    Route::get('/search', [PackageController::class, 'search'])->name('packages.search');
    Route::get('/{slug}', [PackageController::class, 'show'])->name('packages.show');
});

// Destinations
Route::prefix('destinations')->group(function () {
    Route::get('/', [DestinationController::class, 'index'])->name('destinations.index');
    Route::get('/{slug}', [DestinationController::class, 'show'])->name('destinations.show');
});

// Blog
Route::prefix('blog')->group(function () {
    Route::get('/', [BlogController::class, 'index'])->name('blog.index');
    Route::get('/category/{slug}', [BlogController::class, 'category'])->name('blog.category');
    Route::get('/tag/{slug}', [BlogController::class, 'tag'])->name('blog.tag');
    Route::get('/{slug}', [BlogController::class, 'show'])->name('blog.show');
    Route::post('/{slug}/comment', [BlogController::class, 'comment'])->name('blog.comment');
});

// Testimonials
Route::get('/testimonials', [HomeController::class, 'testimonials'])->name('testimonials');

// Admin Routes (Protected)
Route::middleware(['auth', 'role:super_admin|admin|content_manager|sales_agent'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // User Management
    Route::resource('users', UserController::class);
    Route::post('users/{user}/assign-role', [UserController::class, 'assignRole'])->name('users.assign-role');
    Route::post('users/{user}/activate', [UserController::class, 'activate'])->name('users.activate');
    Route::post('users/{user}/deactivate', [UserController::class, 'deactivate'])->name('users.deactivate');
    
    // Enquiry Management
    Route::resource('enquiries', AdminEnquiryController::class);
    Route::post('enquiries/{enquiry}/assign', [AdminEnquiryController::class, 'assign'])->name('enquiries.assign');
    Route::post('enquiries/{enquiry}/status', [AdminEnquiryController::class, 'updateStatus'])->name('enquiries.status');
    Route::get('enquiries/export/excel', [AdminEnquiryController::class, 'exportExcel'])->name('enquiries.export.excel');
    Route::get('enquiries/export/pdf', [AdminEnquiryController::class, 'exportPdf'])->name('enquiries.export.pdf');
    
    // Package Management
    Route::resource('packages', AdminPackageController::class);
    Route::post('packages/{package}/publish', [AdminPackageController::class, 'publish'])->name('packages.publish');
    Route::post('packages/{package}/feature', [AdminPackageController::class, 'feature'])->name('packages.feature');
    Route::post('packages/{package}/gallery', [AdminPackageController::class, 'uploadGallery'])->name('packages.gallery');
    
    // Destination Management
    Route::resource('destinations', AdminDestinationController::class);
    
    // Blog Management
    Route::resource('blog', AdminBlogController::class);
    Route::post('blog/{post}/publish', [AdminBlogController::class, 'publish'])->name('blog.publish');
    
    // Testimonials Management
    Route::resource('testimonials', \App\Http\Controllers\Admin\TestimonialController::class);
    Route::post('testimonials/{testimonial}/approve', [\App\Http\Controllers\Admin\TestimonialController::class, 'approve'])->name('testimonials.approve');
    
    // Homepage Management
    Route::get('homepage/edit', [\App\Http\Controllers\Admin\HomepageController::class, 'edit'])->name('homepage.edit');
    Route::post('homepage', [\App\Http\Controllers\Admin\HomepageController::class, 'update'])->name('homepage.update');
    
    // Settings
    Route::get('settings', [\App\Http\Controllers\Admin\SettingsController::class, 'edit'])->name('settings.edit');
    Route::post('settings', [\App\Http\Controllers\Admin\SettingsController::class, 'update'])->name('settings.update');
});

// Sales Dashboard Routes
Route::middleware(['auth', 'role:sales_agent|admin|super_admin'])
    ->prefix('sales')
    ->name('sales.')
    ->group(function () {
        
    Route::get('/dashboard', [SalesDashboardController::class, 'index'])->name('dashboard');
    Route::get('/enquiries', [\App\Http\Controllers\Sales\EnquiryController::class, 'index'])->name('enquiries.index');
    Route::get('/enquiries/{enquiry}', [\App\Http\Controllers\Sales\EnquiryController::class, 'show'])->name('enquiries.show');
    Route::post('/enquiries/{enquiry}/status', [\App\Http\Controllers\Sales\EnquiryController::class, 'updateStatus'])->name('enquiries.status');
    Route::post('/enquiries/{enquiry}/note', [\App\Http\Controllers\Sales\EnquiryController::class, 'addNote'])->name('enquiries.note');
    Route::post('/enquiries/{enquiry}/reminder', [\App\Http\Controllers\Sales\EnquiryController::class, 'setReminder'])->name('enquiries.reminder');
});

// User Dashboard
Route::middleware(['auth'])
    ->prefix('dashboard')
    ->name('dashboard.')
    ->group(function () {
        
    Route::get('/', [\App\Http\Controllers\UserDashboardController::class, 'index'])->name('index');
    Route::get('/enquiries', [\App\Http\Controllers\UserDashboardController::class, 'enquiries'])->name('enquiries');
    Route::get('/profile', [\App\Http\Controllers\UserDashboardController::class, 'profile'])->name('profile');
    Route::put('/profile', [\App\Http\Controllers\UserDashboardController::class, 'updateProfile'])->name('profile.update');
});
```

### 3.2 API Routes (routes/api.php)

```php
<?php

use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\EnquiryController;
use App\Http\Controllers\Api\V1\PackageController;
use App\Http\Controllers\Api\V1\DestinationController;
use App\Http\Controllers\Api\V1\BlogController;
use App\Http\Controllers\Api\V1\UserController;
use App\Http\Controllers\Api\V1\DashboardController;
use Illuminate\Support\Facades\Route;

// API Version 1
Route::prefix('v1')->group(function () {
    
    // Public API endpoints
    Route::post('/auth/register', [AuthController::class, 'register'])->name('api.register');
    Route::post('/auth/login', [AuthController::class, 'login'])->name('api.login');
    
    // Public content endpoints
    Route::get('/packages', [PackageController::class, 'index'])->name('api.packages.index');
    Route::get('/packages/featured', [PackageController::class, 'featured'])->name('api.packages.featured');
    Route::get('/packages/{slug}', [PackageController::class, 'show'])->name('api.packages.show');
    
    Route::get('/destinations', [DestinationController::class, 'index'])->name('api.destinations.index');
    Route::get('/destinations/featured', [DestinationController::class, 'featured'])->name('api.destinations.featured');
    Route::get('/destinations/{slug}', [DestinationController::class, 'show'])->name('api.destinations.show');
    
    Route::get('/blog', [BlogController::class, 'index'])->name('api.blog.index');
    Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('api.blog.show');
    
    // Protected API endpoints
    Route::middleware('auth:sanctum')->group(function () {
        
        // Authentication
        Route::post('/auth/logout', [AuthController::class, 'logout'])->name('api.logout');
        Route::get('/auth/user', [AuthController::class, 'user'])->name('api.user');
        
        // Enquiries
        Route::post('/enquiries', [EnquiryController::class, 'store'])->name('api.enquiries.store');
        Route::get('/enquiries', [EnquiryController::class, 'index'])->name('api.enquiries.index')
             ->middleware('permission:enquiries.view');
        Route::get('/enquiries/{id}', [EnquiryController::class, 'show'])->name('api.enquiries.show')
             ->middleware('permission:enquiries.view');
        Route::put('/enquiries/{id}', [EnquiryController::class, 'update'])->name('api.enquiries.update')
             ->middleware('permission:enquiries.edit');
        Route::delete('/enquiries/{id}', [EnquiryController::class, 'destroy'])->name('api.enquiries.destroy')
             ->middleware('permission:enquiries.delete');
        Route::post('/enquiries/{id}/assign', [EnquiryController::class, 'assign'])->name('api.enquiries.assign')
             ->middleware('permission:enquiries.assign');
        Route::put('/enquiries/{id}/status', [EnquiryController::class, 'updateStatus'])->name('api.enquiries.status')
             ->middleware('permission:enquiries.edit');
        
        // Packages (Admin)
        Route::post('/packages', [PackageController::class, 'store'])->name('api.packages.store')
             ->middleware('permission:packages.create');
        Route::put('/packages/{id}', [PackageController::class, 'update'])->name('api.packages.update')
             ->middleware('permission:packages.edit');
        Route::delete('/packages/{id}', [PackageController::class, 'destroy'])->name('api.packages.destroy')
             ->middleware('permission:packages.delete');
        
        // Destinations (Admin)
        Route::post('/destinations', [DestinationController::class, 'store'])->name('api.destinations.store')
             ->middleware('permission:destinations.create');
        Route::put('/destinations/{id}', [DestinationController::class, 'update'])->name('api.destinations.update')
             ->middleware('permission:destinations.edit');
        Route::delete('/destinations/{id}', [DestinationController::class, 'destroy'])->name('api.destinations.destroy')
             ->middleware('permission:destinations.delete');
        
        // Blog (Admin)
        Route::post('/blog', [BlogController::class, 'store'])->name('api.blog.store')
             ->middleware('permission:blog.create');
        Route::put('/blog/{id}', [BlogController::class, 'update'])->name('api.blog.update')
             ->middleware('permission:blog.edit');
        Route::delete('/blog/{id}', [BlogController::class, 'destroy'])->name('api.blog.destroy')
             ->middleware('permission:blog.delete');
        
        // Users (Admin)
        Route::get('/users', [UserController::class, 'index'])->name('api.users.index')
             ->middleware('permission:users.view');
        Route::post('/users', [UserController::class, 'store'])->name('api.users.store')
             ->middleware('permission:users.create');
        Route::get('/users/{id}', [UserController::class, 'show'])->name('api.users.show')
             ->middleware('permission:users.view');
        Route::put('/users/{id}', [UserController::class, 'update'])->name('api.users.update')
             ->middleware('permission:users.edit');
        Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('api.users.destroy')
             ->middleware('permission:users.delete');
        
        // Dashboard
        Route::get('/dashboard/stats', [DashboardController::class, 'stats'])->name('api.dashboard.stats');
        Route::get('/dashboard/recent', [DashboardController::class, 'recent'])->name('api.dashboard.recent');
    });
});
```

## 4. Service Layer Implementation

### 4.1 EnquiryService

```php
<?php

namespace App\Services;

use App\Models\Enquiry;
use App\Models\EnquiryStatusHistory;
use App\Models\FollowUpReminder;
use App\Repositories\Interfaces\EnquiryRepositoryInterface;
use App\Notifications\EnquiryAssigned;
use App\Notifications\EnquiryStatusChanged;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;

class EnquiryService
{
    protected $enquiryRepository;

    public function __construct(EnquiryRepositoryInterface $enquiryRepository)
    {
        $this->enquiryRepository = $enquiryRepository;
    }

    public function createEnquiry(array $data): Enquiry
    {
        return DB::transaction(function () use ($data) {
            $enquiry = $this->enquiryRepository->create($data);
            
            // Create initial status history
            EnquiryStatusHistory::create([
                'enquiry_id' => $enquiry->id,
                'status' => 'new',
                'changed_by' => auth()->id() ?? null,
                'changed_at' => now()
            ]);
            
            return $enquiry;
        });
    }

    public function assignEnquiry(Enquiry $enquiry, int $userId): Enquiry
    {
        $enquiry = $this->enquiryRepository->update($enquiry->id, [
            'assigned_to' => $userId
        ]);
        
        // Notify assigned user
        $assignedUser = $enquiry->assignedTo;
        if ($assignedUser) {
            Notification::send($assignedUser, new EnquiryAssigned($enquiry));
        }
        
        return $enquiry;
    }

    public function updateStatus(Enquiry $enquiry, string $status, string $notes = null): Enquiry
    {
        return DB::transaction(function () use ($enquiry, $status, $notes) {
            // Update enquiry status
            $enquiry = $this->enquiryRepository->update($enquiry->id, [
                'status' => $status,
                'last_contacted_at' => now()
            ]);
            
            // Record status change
            EnquiryStatusHistory::create([
                'enquiry_id' => $enquiry->id,
                'status' => $status,
                'changed_by' => auth()->id(),
                'notes' => $notes,
                'changed_at' => now()
            ]);
            
            // Notify stakeholders
            $this->notifyStatusChange($enquiry, $status);
            
            return $enquiry;
        });
    }

    public function setFollowUpReminder(Enquiry $enquiry, \DateTime $date, string $time = null, string $notes = null): FollowUpReminder
    {
        return FollowUpReminder::create([
            'enquiry_id' => $enquiry->id,
            'reminder_date' => $date->format('Y-m-d'),
            'reminder_time' => $time,
            'notes' => $notes,
            'status' => 'pending'
        ]);
    }

    protected function notifyStatusChange(Enquiry $enquiry, string $status): void
    {
        // Notify assigned user
        if ($enquiry->assignedTo) {
            Notification::send($enquiry->assignedTo, new EnquiryStatusChanged($enquiry, $status));
        }
        
        // Notify customer if status is confirmed
        if ($status === 'confirmed' && $enquiry->user) {
            // Send confirmation email to customer
        }
    }

    public function getEnquiryStatistics(array $filters = []): array
    {
        return [
            'total' => $this->enquiryRepository->count($filters),
            'new' => $this->enquiryRepository->count(array_merge($filters, ['status' => 'new'])),
            'contacted' => $this->enquiryRepository->count(array_merge($filters, ['status' => 'contacted'])),
            'quotation_sent' => $this->enquiryRepository->count(array_merge($filters, ['status' => 'quotation_sent'])),
            'negotiation' => $this->enquiryRepository->count(array_merge($filters, ['status' => 'negotiation'])),
            'confirmed' => $this->enquiryRepository->count(array_merge($filters, ['status' => 'confirmed'])),
            'cancelled' => $this->enquiryRepository->count(array_merge($filters, ['status' => 'cancelled'])),
        ];
    }
}
```

### 4.2 PackageService

```php
<?php

namespace App\Services;

use App\Models\SafariPackage;
use App\Models\PackageGallery;
use App\Repositories\Interfaces\PackageRepositoryInterface;
use App\Services\FileUploadService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PackageService
{
    protected $packageRepository;
    protected $fileUploadService;

    public function __construct(
        PackageRepositoryInterface $packageRepository,
        FileUploadService $fileUploadService
    ) {
        $this->packageRepository = $packageRepository;
        $this->fileUploadService = $fileUploadService;
    }

    public function createPackage(array $data): SafariPackage
    {
        return DB::transaction(function () use ($data) {
            // Handle featured image upload
            if (isset($data['featured_image'])) {
                $data['featured_image'] = $this->fileUploadService->upload(
                    $data['featured_image'],
                    'packages/featured',
                    'public'
                );
            }
            
            // Generate slug if not provided
            if (!isset($data['slug']) || empty($data['slug'])) {
                $data['slug'] = Str::slug($data['title']);
            }
            
            // Create package
            $package = $this->packageRepository->create($data);
            
            // Handle gallery uploads
            if (isset($data['gallery'])) {
                foreach ($data['gallery'] as $index => $image) {
                    $imagePath = $this->fileUploadService->upload(
                        $image,
                        'packages/gallery',
                        'public'
                    );
                    
                    PackageGallery::create([
                        'package_id' => $package->id,
                        'image_path' => $imagePath,
                        'alt_text' => $data['gallery_alt'][$index] ?? null,
                        'display_order' => $index
                    ]);
                }
            }
            
            // Sync destinations
            if (isset($data['destinations'])) {
                $package->destinations()->sync($data['destinations']);
            }
            
            return $package;
        });
    }

    public function updatePackage(SafariPackage $package, array $data): SafariPackage
    {
        return DB::transaction(function () use ($package, $data) {
            // Handle featured image update
            if (isset($data['featured_image'])) {
                // Delete old image
                if ($package->featured_image) {
                    $this->fileUploadService->delete($package->featured_image);
                }
                
                $data['featured_image'] = $this->fileUploadService->upload(
                    $data['featured_image'],
                    'packages/featured',
                    'public'
                );
            }
            
            // Update slug if title changed
            if (isset($data['title']) && $data['title'] !== $package->title) {
                $data['slug'] = Str::slug($data['title']);
            }
            
            // Update package
            $package = $this->packageRepository->update($package->id, $data);
            
            // Handle gallery updates
            if (isset($data['gallery'])) {
                // Remove old gallery images
                foreach ($package->gallery as $oldImage) {
                    $this->fileUploadService->delete($oldImage->image_path);
                    $oldImage->delete();
                }
                
                // Add new gallery images
                foreach ($data['gallery'] as $index => $image) {
                    $imagePath = $this->fileUploadService->upload(
                        $image,
                        'packages/gallery',
                        'public'
                    );
                    
                    PackageGallery::create([
                        'package_id' => $package->id,
                        'image_path' => $imagePath,
                        'alt_text' => $data['gallery_alt'][$index] ?? null,
                        'display_order' => $index
                    ]);
                }
            }
            
            // Sync destinations
            if (isset($data['destinations'])) {
                $package->destinations()->sync($data['destinations']);
            }
            
            return $package;
        });
    }

    public function publishPackage(SafariPackage $package): SafariPackage
    {
        return $this->packageRepository->update($package->id, [
            'is_published' => true,
            'published_at' => now()
        ]);
    }

    public function featurePackage(SafariPackage $package, ?DateTime $until = null): SafariPackage
    {
        return $this->packageRepository->update($package->id, [
            'is_featured' => true,
            'featured_until' => $until
        ]);
    }

    public function searchPackages(array $filters): \Illuminate\Pagination\LengthAwarePaginator
    {
        $query = SafariPackage::query()->published();
        
        // Apply filters
        if (isset($filters['destination'])) {
            $query->whereHas('destinations', function ($q) use ($filters) {
                $q->where('slug', $filters['destination']);
            });
        }
        
        if (isset($filters['category'])) {
            $query->where('category_id', $filters['category']);
        }
        
        if (isset($filters['min_price'])) {
            $query->where('price', '>=', $filters['min_price']);
        }
        
        if (isset($filters['max_price'])) {
            $query->where('price', '<=', $filters['max_price']);
        }
        
        if (isset($filters['min_duration'])) {
            $query->where('duration', '>=', $filters['min_duration']);
        }
        
        if (isset($filters['max_duration'])) {
            $query->where('duration', '<=', $filters['max_duration']);
        }
        
        if (isset($filters['search'])) {
            $query->where(function ($q) use ($filters) {
                $q->where('title', 'like', '%' . $filters['search'] . '%')
                  ->orWhere('short_desc', 'like', '%' . $filters['search'] . '%')
                  ->orWhere('location', 'like', '%' . $filters['search'] . '%');
            });
        }
        
        // Apply sorting
        $sortBy = $filters['sort_by'] ?? 'created_at';
        $sortOrder = $filters['sort_order'] ?? 'desc';
        $query->orderBy($sortBy, $sortOrder);
        
        return $query->paginate(12);
    }
}
```

## 5. Repository Pattern Implementation

### 5.1 Repository Interface

```php
<?php

namespace App\Repositories\Interfaces;

interface EnquiryRepositoryInterface
{
    public function all(array $filters = []);
    public function find(int $id);
    public function create(array $data);
    public function update(int $id, array $data);
    public function delete(int $id);
    public function count(array $filters = []);
    public function findByUser(int $userId);
    public function findByAssignedTo(int $userId);
    public function withRelations(array $relations);
}
```

### 5.2 Repository Implementation

```php
<?php

namespace App\Repositories;

use App\Models\Enquiry;
use App\Repositories\Interfaces\EnquiryRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class EnquiryRepository implements EnquiryRepositoryInterface
{
    protected $model;

    public function __construct(Enquiry $enquiry)
    {
        $this->model = $enquiry;
    }

    public function all(array $filters = []): LengthAwarePaginator
    {
        $query = $this->model->query();
        
        // Apply filters
        if (isset($filters['status'])) {
            $query->where('status', $filters['status']);
        }
        
        if (isset($filters['assigned_to'])) {
            $query->where('assigned_to', $filters['assigned_to']);
        }
        
        if (isset($filters['package_id'])) {
            $query->where('package_id', $filters['package_id']);
        }
        
        if (isset($filters['date_from'])) {
            $query->where('created_at', '>=', $filters['date_from']);
        }
        
        if (isset($filters['date_to'])) {
            $query->where('created_at', '<=', $filters['date_to']);
        }
        
        if (isset($filters['search'])) {
            $query->where(function ($q) use ($filters) {
                $q->where('full_name', 'like', '%' . $filters['search'] . '%')
                  ->orWhere('email', 'like', '%' . $filters['search'] . '%')
                  ->orWhere('phone', 'like', '%' . $filters['search'] . '%');
            });
        }
        
        // Eager load relationships
        $query->with(['user', 'assignedTo', 'package']);
        
        // Order by
        $query->orderBy('created_at', 'desc');
        
        // Return paginated results
        return $query->paginate($filters['per_page'] ?? 20);
    }

    public function find(int $id): ?Enquiry
    {
        return $this->model->with(['user', 'assignedTo', 'package', 'notes.user', 'statusHistory'])->find($id);
    }

    public function create(array $data): Enquiry
    {
        return $this->model->create($data);
    }

    public function update(int $id, array $data): Enquiry
    {
        $enquiry = $this->find($id);
        $enquiry->update($data);
        return $enquiry;
    }

    public function delete(int $id): bool
    {
        return $this->model->destroy($id);
    }

    public function count(array $filters = []): int
    {
        $query = $this->model->query();
        
        foreach ($filters as $key => $value) {
            $query->where($key, $value);
        }
        
        return $query->count();
    }

    public function findByUser(int $userId)
    {
        return $this->model->where('user_id', $userId)->get();
    }

    public function findByAssignedTo(int $userId)
    {
        return $this->model->where('assigned_to', $userId)->get();
    }

    public function withRelations(array $relations)
    {
        return $this->model->with($relations)->get();
    }
}
```

## 6. Middleware Implementation

### 6.1 Role Middleware

```php
<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (!auth()->check() || !auth()->user()->hasRole($role)) {
            abort(403, 'You do not have permission to access this resource.');
        }

        return $next($request);
    }
}
```

### 6.2 Permission Middleware

```php
<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckPermission
{
    public function handle(Request $request, Closure $next, string $permission): Response
    {
        if (!auth()->check() || !auth()->user()->can($permission)) {
            abort(403, 'You do not have permission to perform this action.');
        }

        return $next($request);
    }
}
```

### 6.3 Activity Logging Middleware

```php
<?php

namespace App\Http\Middleware;

use App\Models\ActivityLog;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LogUserActivity
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);
        
        if (auth()->check()) {
            ActivityLog::create([
                'user_id' => auth()->id(),
                'action' => $request->method() . ' ' . $request->route()->getName(),
                'description' => 'User accessed ' . $request->path(),
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);
        }
        
        return $response;
    }
}
```

## 7. Configuration Files

### 7.1 RouteServiceProvider

```php
<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    public const HOME = '/dashboard';

    protected function boot(): void
    {
        $this->configureRateLimiting();
        $this->routes(function () {
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));
            
            Route::middleware('web')
                ->group(base_path('routes/web.php'));
        });
    }

    protected function configureRateLimiting(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });
    }
}
```

This comprehensive Laravel project structure provides a solid foundation for building the Safari Tour Management System with proper separation of concerns, scalability, and maintainability.