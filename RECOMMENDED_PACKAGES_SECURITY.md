# Safari Tour Management System - Recommended Packages & Security Best Practices

## 1. Recommended Laravel Packages

### 1.1 Core Packages

#### Laravel Breeze
**Purpose**: Authentication scaffolding  
**Version**: Latest  
**Installation**: `composer require laravel/breeze --dev`  
**Configuration**: `php artisan breeze:install blade`

**Features**:
- User registration and login
- Email verification
- Password reset
- Profile management
- Two-factor authentication (optional)

**Why Use**: Provides a solid, secure authentication foundation with minimal setup time.

---

#### Spatie Laravel Permission
**Purpose**: Role-based access control  
**Version**: Latest  
**Installation**: `composer require spatie/laravel-permission`

**Features**:
- Role and permission management
- Blade directives for permission checks
- Middleware for route protection
- API permission checking
- Database caching for permissions

**Why Use**: Industry-standard package for robust permission management with excellent documentation.

**Configuration**:
```php
// config/permission.php
return [
    'models' => [
        'permission' => Spatie\Permission\Models\Permission::class,
        'role' => Spatie\Permission\Models\Role::class,
    ],
    'table_names' => [
        'roles' => 'roles',
        'permissions' => 'permissions',
        'model_has_permissions' => 'model_has_permissions',
        'model_has_roles' => 'model_has_roles',
        'role_has_permissions' => 'role_has_permissions',
    ],
];
```

---

#### Laravel Sanctum
**Purpose**: API authentication  
**Version**: Latest (included in Laravel 12)  
**Installation**: Built-in with Laravel 12

**Features**:
- Token-based API authentication
- SPA authentication
- Mobile app authentication
- Token management
- Ability-based tokens

**Why Use**: Official Laravel package for API authentication, lightweight and secure.

**Configuration**:
```php
// config/sanctum.php
return [
    'stateful' => explode(',', env('SANCTUM_STATEFUL_DOMAINS', sprintf(
        '%s%s',
        'localhost,localhost:3000,127.0.0.1,127.0.0.1:8000,::1',
        env('APP_URL') ? ','.parse_url(env('APP_URL'), PHP_URL_HOST) : ''
    ))),
    'guard' => ['web'],
    'expiration' => null, // Set to 60 for 1 hour expiration
    'middleware' => [
        'verify_csrf_token' => App\Http\Middleware\VerifyCsrfToken::class,
        'encrypt_cookies' => App\Http\Middleware\EncryptCookies::class,
    ],
];
```

---

### 1.2 File Handling & Image Processing

#### Intervention Image
**Purpose**: Image manipulation  
**Version**: Latest  
**Installation**: `composer require intervention/image`

**Features**:
- Image resizing and cropping
- Image compression
- Watermarking
- Format conversion
- Filter applications

**Why Use**: Powerful image processing library with excellent Laravel integration.

**Usage Example**:
```php
use Intervention\Image\Facades\Image;

$image = Image::make($file->path())
    ->resize(800, 600, function ($constraint) {
        $constraint->aspectRatio();
    })
    ->encode('jpg', 80)
    ->save(storage_path('app/public/' . $path));
```

---

#### Laravel Media Library
**Purpose**: Advanced file management  
**Version**: Latest  
**Installation**: `composer require spatie/laravel-medialibrary`

**Features**:
- Multiple file collections
- Image conversions
- Media management
- File organization
- CDN integration

**Why Use**: Comprehensive media management with automatic conversions and optimizations.

---

### 1.3 Export & Import

#### Laravel Excel
**Purpose**: Excel import/export  
**Version**: Latest  
**Installation**: `composer require maatwebsite/excel`

**Features**:
- Excel export
- Excel import
- CSV support
- Batch processing
- Queued exports

**Why Use**: Industry-standard Excel handling with excellent performance.

**Usage Example**:
```php
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\EnquiriesExport;

return Excel::download(new EnquiriesExport, 'enquiries.xlsx');
```

---

#### Laravel DomPDF
**Purpose**: PDF generation  
**Version**: Latest  
**Installation**: `composer require barryvdh/laravel-dompdf`

**Features**:
- PDF generation from Blade views
- HTML to PDF conversion
- Custom styling
- Image support
- Page formatting

**Why Use**: Easy PDF generation using familiar Blade templates.

---

### 1.4 Search & Caching

#### Laravel Scout
**Purpose**: Full-text search  
**Version**: Latest (included in Laravel 12)  
**Installation**: Built-in with Laravel 12

**Features**:
- Full-text search
- Driver support (Algolia, Meilisearch, etc.)
- Database driver for simple search
- Indexed searching
- Scout extended features

**Why Use**: Official Laravel search solution with multiple driver options.

**Configuration**:
```php
// config/scout.php
return [
    'driver' => env('SCOUT_DRIVER', 'database'),
    'queue' => env('SCOUT_QUEUE', true),
    'before_search' => null,
    'after_search' => null,
    'prefix' => env('SCOUT_PREFIX', ''),
];
```

---

### 1.5 Notifications & Email

#### Laravel Notifications
**Purpose**: Notification system  
**Version**: Latest (included in Laravel 12)  
**Installation**: Built-in with Laravel 12

**Features**:
- Email notifications
- SMS notifications
- Database notifications
- Broadcast notifications
- Notification channels

**Why Use**: Built-in Laravel notification system with multiple channel support.

---

#### Markdown Mail
**Purpose**: Email templating  
**Version**: Latest (included in Laravel 12)  
**Installation**: Built-in with Laravel 12

**Features**:
- Markdown email templates
- Responsive design
- Component-based emails
- Email themes
- Preview emails in browser

**Why Use**: Beautiful, responsive email templates with minimal effort.

---

### 1.6 Monitoring & Debugging

#### Laravel Telescope
**Purpose**: Debug assistant  
**Version**: Latest  
**Installation**: `composer require laravel/telescope --dev`

**Features**:
- Request monitoring
- Database query monitoring
- Command monitoring
- Schedule monitoring
- Exception tracking

**Why Use**: Excellent debugging tool for development environments.

**Configuration**:
```php
// Only enable in local environment
if (app()->environment('local')) {
    app()->register(TelescopeServiceProvider::class);
}
```

---

#### Laravel Debugbar
**Purpose**: Debug toolbar  
**Version**: Latest  
**Installation**: `composer require barryvdh/laravel-debugbar --dev`

**Features**:
- Request/Response information
- Database queries
- Views and templates
- Route information
- Authentication details

**Why Use**: Quick debugging information during development.

---

### 1.7 Backup & Maintenance

#### Laravel Backup
**Purpose**: Database and file backups  
**Version**: Latest  
**Installation**: `composer require spatie/laravel-backup`

**Features**:
- Database backups
- File backups
- Scheduled backups
- Multiple storage destinations
- Backup notifications

**Why Use**: Comprehensive backup solution with minimal configuration.

**Configuration**:
```php
// config/backup.php
return [
    'backup' => [
        'name' => env('APP_NAME', 'laravel-backup'),
        'source' => [
            'files' => [
                'include' => [base_path()],
                'exclude' => [base_path('vendor')],
            ],
            'databases' => [
                'mysql',
            ],
        ],
    ],
];
```

---

### 1.8 Testing

#### Laravel Dusk
**Purpose**: Browser testing  
**Version**: Latest  
**Installation**: `composer require laravel/dusk --dev`

**Features**:
- Browser automation
- JavaScript testing
- Real user simulation
- Screenshot capture
- Multi-browser testing

**Why Use**: Comprehensive browser testing for critical user flows.

---

#### Pest PHP
**Purpose**: Elegant testing framework  
**Version**: Latest  
**Installation**: `composer require pestphp/pest --dev`

**Features**:
- Beautiful syntax
- Parallel testing
- Coverage reports
- Plugin system
- Better output

**Why Use**: Modern testing framework with better developer experience.

---

### 1.9 Code Quality

#### Laravel Pint
**Purpose**: Code style fixer  
**Version**: Latest  
**Installation**: `composer require laravel/pint --dev`

**Features**:
- PSR-12 compliance
- Automatic code formatting
- CI/CD integration
- Configurable rules
- Fast execution

**Why Use**: Official Laravel code style tool with zero configuration.

**Usage**:
```bash
// Run on all files
./vendor/bin/pint

// Run on specific directory
./vendor/bin/pint app
```

---

#### PHPStan
**Purpose**: Static analysis  
**Version**: Latest  
**Installation**: `composer require phpstan/phpstan --dev`

**Features**:
- Static type checking
- Bug detection
- Dead code detection
- Level-based analysis
- IDE integration

**Why Use**: Catch bugs and type errors before runtime.

**Configuration**:
```php
// phpstan.neon
parameters:
    level: 8
    paths:
        - app
```

---

### 1.10 API Documentation

#### Laravel API Documentation Generator
**Purpose**: Auto-generate API docs  
**Version**: Latest  
**Installation**: `composer require mpociot/laravel-apidoc-generator`

**Features**:
- Automatic API documentation
- Request/response examples
- Authentication documentation
- Endpoint grouping
- Markdown export

**Why Use**: Generate beautiful API documentation from actual code.

---

## 2. Security Best Practices

### 2.1 Authentication & Authorization

#### 2.1.1 Password Security
```php
// Use strong password hashing (Laravel default)
Hash::make($password); // Uses bcrypt by default

// Use Argon2 for enhanced security (PHP 7.3+)
'password' => [
    'driver' => 'argon2',
],
```

#### 2.1.2 Session Security
```php
// config/session.php
return [
    'driver' => env('SESSION_DRIVER', 'redis'),
    'lifetime' => env('SESSION_LIFETIME', 120),
    'expire_on_close' => false,
    'encrypt' => true,
    'files' => storage_path('framework/sessions'),
    'connection' => env('SESSION_CONNECTION', null),
    'table' => 'sessions',
    'store' => null,
    'lottery' => [2, 100],
    'cookie' => env('SESSION_COOKIE_NAME', 'laravel_session'),
    'path' => '/',
    'domain' => env('SESSION_DOMAIN', null),
    'secure' => env('SESSION_SECURE_COOKIE', true), // Always use HTTPS
    'http_only' => true, // Prevent JavaScript access
    'same_site' => 'lax', // CSRF protection
];
```

#### 2.1.3 CSRF Protection
```php
// Ensure CSRF protection is enabled (Laravel default)
// All POST, PUT, DELETE requests require CSRF token

// Add CSRF token to forms
<form method="POST">
    @csrf
    ...
</form>

// For AJAX requests
headers: {
    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
}
```

#### 2.1.4 Rate Limiting
```php
// config/cors.php - API rate limiting
return [
    'paths' => ['api/*'],
    'allowed_methods' => ['*'],
    'allowed_origins' => ['*'],
    'allowed_origins_patterns' => [],
    'allowed_headers' => ['*'],
    'exposed_headers' => [],
    'max_age' => 0,
    'supports_credentials' => true,
];

// Implement in routes/throttle.php
Route::middleware('throttle:60,1')->group(function () {
    Route::post('/login', ...);
});

// Custom rate limiting for API
Route::middleware(['auth:sanctum', 'throttle:api'])->group(function () {
    // API routes
});
```

### 2.2 Input Validation & Sanitization

#### 2.2.1 Form Request Validation
```php
class StoreEnquiryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'country' => 'required|string|max:100',
            'message' => 'nullable|string|max:5000',
            // Custom validation rules
        ];
    }

    public function sanitize(): array
    {
        return [
            'full_name' => 'strip_tags|trim',
            'email' => 'trim|lowercase',
            'message' => 'strip_tags',
        ];
    }
}
```

#### 2.2.2 SQL Injection Prevention
```php
// Use Eloquent ORM (automatically prevents SQL injection)
$user = User::where('email', $email)->first();

// Use parameter binding in raw queries
$users = DB::select('SELECT * FROM users WHERE email = :email', ['email' => $email]);

// Never use raw user input directly
$users = DB::select("SELECT * FROM users WHERE email = '$email'"); // DON'T DO THIS
```

#### 2.2.3 XSS Prevention
```php
// Blade auto-escapes output (default)
{{ $user->name }}

// Use {!! !!} only for trusted HTML
{!! $trustedHtmlContent !!}

// For user-generated content, use HTML Purifier
composer require stevegrunwell/html-purifier

use Purifier;

$cleanHtml = Purifier::clean($userInput);
```

### 2.3 File Upload Security

#### 2.3.1 File Validation
```php
public function store(Request $request)
{
    $validated = $request->validate([
        'image' => [
            'required',
            'file',
            'image',
            'max:10240', // 10MB max
            'mimes:jpeg,png,jpg,gif',
            'dimensions:min_width=800,min_height=600,max_width=4000,max_height=4000',
        ],
    ]);

    $file = $request->file('image');
    
    // Generate secure filename
    $filename = uniqid() . '_' . time() . '.' . $file->extension();
    
    // Store in secure location
    $path = $file->storeAs('public/uploads', $filename);
    
    return $path;
}
```

#### 2.3.2 File Storage Security
```php
// config/filesystems.php
return [
    'default' => env('FILESYSTEM_DISK', 'local'),
    'disks' => [
        'local' => [
            'driver' => 'local',
            'root' => storage_path('app'),
            'serve' => true,
        ],
        'public' => [
            'driver' => 'local',
            'root' => storage_path('app/public'),
            'url' => env('APP_URL').'/storage',
            'visibility' => 'private', // Default to private
        ],
        's3' => [
            'driver' => 's3',
            'key' => env('AWS_ACCESS_KEY_ID'),
            'secret' => env('AWS_SECRET_ACCESS_KEY'),
            'region' => env('AWS_DEFAULT_REGION'),
            'bucket' => env('AWS_BUCKET'),
            'url' => env('AWS_URL'),
            'endpoint' => env('AWS_ENDPOINT'),
            'use_path_style_endpoint' => env('AWS_USE_PATH_STYLE_ENDPOINT', false),
        ],
    ],
];
```

### 2.4 API Security

#### 2.4.1 Token Security
```php
// Set token expiration
// config/sanctum.php
'expiration' => 60, // 1 hour

// Regenerate tokens periodically
public function refreshToken(Request $request)
{
    $user = $request->user();
    $user->currentAccessToken()->delete();
    return $user->createToken('new-token')->plainTextToken;
}

// Implement IP-based token access
public function authenticate(Request $request)
{
    $token = $request->bearerToken();
    if (!$this->isValidToken($token, $request->ip())) {
        abort(401);
    }
}
```

#### 2.4.2 API Versioning
```php
// Use API versioning for backward compatibility
Route::prefix('api/v1')->group(function () {
    // Version 1 endpoints
});

Route::prefix('api/v2')->group(function () {
    // Version 2 endpoints
});
```

#### 2.4.3 CORS Configuration
```php
// config/cors.php
return [
    'paths' => ['api/*'],
    'allowed_methods' => ['*'],
    'allowed_origins' => ['https://yourdomain.com'], // Specific domains
    'allowed_origins_patterns' => [],
    'allowed_headers' => ['Content-Type', 'Authorization'],
    'exposed_headers' => [],
    'max_age' => 0,
    'supports_credentials' => true,
];
```

### 2.5 Database Security

#### 2.5.1 Database Configuration
```php
// .env - Never commit to version control
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=safari_tours
DB_USERNAME=your_database_user
DB_PASSWORD=your_secure_password

// Use strong database passwords
// Restrict database user permissions
// Enable SSL for database connections (if remote)
```

#### 2.5.2 Query Optimization
```php
// Use eager loading to prevent N+1 queries
$packages = SafariPackage::with(['category', 'destinations'])->get();

// Use select to limit columns
$users = User::select('id', 'name', 'email')->get();

// Use indexes for frequently queried columns
Schema::table('enquiries', function (Blueprint $table) {
    $table->index(['status', 'created_at']);
});
```

#### 2.5.3 Database Encryption
```php
// Use Laravel encryption for sensitive data
use Illuminate\Support\Facades\Crypt;

$encrypted = Crypt::encryptString($sensitiveData);
$decrypted = Crypt::decryptString($encrypted);

// For model attributes
class Enquiry extends Model
{
    protected $casts = [
        'phone' => 'encrypted',
        'email' => 'encrypted',
    ];
}
```

### 2.6 Email Security

#### 2.6.1 SMTP Configuration
```php
// .env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-specific-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@safaritours.com
MAIL_FROM_NAME="${APP_NAME}"

// Always use encryption (TLS/SSL)
// Use app-specific passwords, not regular passwords
```

#### 2.6.2 Email Content Security
```php
// Sanitize email content
use HTMLPurifier;

$purifier = new HTMLPurifier();
$cleanContent = $purifier->purify($userInput);

// Use SPF, DKIM, and DMARC records
// Validate sender email addresses
```

### 2.7 Logging & Monitoring

#### 2.7.1 Logging Configuration
```php
// config/logging.php
return [
    'default' => env('LOG_CHANNEL', 'stack'),
    'channels' => [
        'stack' => [
            'driver' => 'stack',
            'channels' => ['daily', 'slack'],
        ],
        'daily' => [
            'driver' => 'daily',
            'path' => storage_path('logs/laravel.log'),
            'level' => env('LOG_LEVEL', 'debug'),
            'days' => 14,
        ],
        'slack' => [
            'driver' => 'slack',
            'url' => env('LOG_SLACK_WEBHOOK_URL'),
            'username' => 'Laravel Log',
            'emoji' => ':boom:',
            'level' => env('LOG_LEVEL', 'critical'),
        ],
    ],
];
```

#### 2.7.2 Activity Logging
```php
// Log user activities
ActivityLog::create([
    'user_id' => auth()->id(),
    'action' => $action,
    'description' => $description,
    'ip_address' => $request->ip(),
    'user_agent' => $request->userAgent(),
]);

// Monitor for suspicious activity
// Implement IP blacklisting for repeated failed login attempts
```

### 2.8 HTTPS & SSL

#### 2.8.1 Force HTTPS
```php
// app/Providers/AppServiceProvider.php
public function boot(): void
{
    if (app()->environment('production')) {
        URL::forceScheme('https');
    }
}

// .env
APP_URL=https://yourdomain.com
ASSET_URL=https://yourdomain.com
```

#### 2.8.2 SSL Configuration
```php
// Use Let's Encrypt for free SSL certificates
// Configure HSTS headers
// Implement secure cookie flags
```

### 2.9 Environment Configuration

#### 2.9.1 Environment Security
```php
// .env.example - Commit this to version control
DB_HOST=your_db_host
DB_DATABASE=your_db_name
DB_USERNAME=your_db_username
DB_PASSWORD=your_db_password

// .env - Never commit to version control
// Add to .gitignore

// Encrypt environment variables for production
php artisan env:encrypt
```

#### 2.9.2 Configuration Caching
```php
// Cache configuration in production
php artisan config:cache
php artisan route:cache
php artisan view:cache

// Clear cache when deploying
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

### 2.10 Dependency Management

#### 2.10.1 Package Security
```bash
# Regularly update packages
composer update

# Check for security vulnerabilities
composer audit

# Use lock file for consistency
# Review packages before adding
```

#### 2.10.2 Composer Security
```bash
# Use Composer 2.x for improved security
composer self-update --2

# Use trusted package sources
# Review package maintainers
# Monitor package updates for security issues
```

## 3. Performance Best Practices

### 3.1 Database Optimization
```php
// Use eager loading
$packages = SafariPackage::with(['category', 'destinations'])->get();

// Use pagination for large datasets
$enquiries = Enquiry::paginate(20);

// Use query caching
$packages = Cache::remember('packages.all', 3600, function () {
    return SafariPackage::all();
});

// Optimize N+1 queries
// Use database indexes
// Use read replicas for read-heavy operations
```

### 3.2 Caching Strategy
```php
// Use Redis for caching
CACHE_DRIVER=redis

// Cache frequently accessed data
$categories = Cache::remember('categories', 3600, function () {
    return PackageCategory::all();
});

// Cache query results
$packages = SafariPackage::cacheFor(3600)->get();

// Use HTTP caching headers
return response()->json($data)->header('Cache-Control', 'max-age=3600');
```

### 3.3 Frontend Optimization
```php
// Use asset versioning
mix.js('resources/js/app.js', 'public/js')
   .version();

// Enable lazy loading
<img loading="lazy" src="image.jpg" alt="Description">

// Minify assets
mix.sass('resources/sass/app.scss', 'public/css')
   .options({
      processCssUrls: false,
   })
   .minify('public/css/app.css');

// Use CDN for static assets
ASSET_URL=https://cdn.yourdomain.com
```

### 3.4 Queue System
```php
// Use queues for time-consuming tasks
php artisan queue:work

// Configure queue driver
QUEUE_CONNECTION=redis

// Dispatch jobs to queues
ProcessEnquiryExport::dispatch($enquiryIds)->onQueue('exports');

// Monitor queue performance
// Implement queue monitoring (Laravel Horizon)
```

## 4. Monitoring & Maintenance

### 4.1 Application Monitoring
```bash
# Install Laravel Telescope for development
composer require laravel/telescope --dev

# Use external monitoring for production
# - Sentry for error tracking
# - New Relic for performance monitoring
# - Loggly for log management
```

### 4.2 Health Checks
```php
// Implement health check endpoint
Route::get('/health', function () {
    return response()->json([
        'status' => 'ok',
        'database' => DB::connection()->getPdo() ? 'connected' : 'disconnected',
        'cache' => Cache::get('health_check') ? 'connected' : 'disconnected',
    ]);
});
```

### 4.3 Backup Strategy
```php
// Configure automated backups
// Schedule daily database backups
$schedule->command('backup:run --only-db')->daily();

// Schedule weekly full backups
$schedule->command('backup:run')->weekly();

// Monitor backup success/failure
// Test restore procedures regularly
```

## 5. Compliance & Legal

### 5.1 GDPR Compliance
```php
// Implement data export functionality
Route::get('/api/user/data-export', function () {
    return auth()->user()->exportData();
});

// Implement data deletion functionality
Route::delete('/api/user/data-delete', function () {
    return auth()->user()->delete();
});

// Cookie consent banner
// Privacy policy
// Terms of service
```

### 5.2 Data Protection
```php
// Encrypt sensitive data
// Implement access logs
// Data retention policies
// Right to be forgotten
// Data breach notification procedures
```

This comprehensive guide provides all the recommended packages and security best practices for building a secure, performant Safari Tour Management System.