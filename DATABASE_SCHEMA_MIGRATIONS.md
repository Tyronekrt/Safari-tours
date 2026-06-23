# Safari Tour Management System - Database Schema & Laravel Migrations

## 1. Database Schema Overview

This document provides the complete database schema and Laravel 12 migration files for the Safari Tour Management System.

## 2. Laravel Migration Files

### 2.1 Installation Commands

```bash
# Create Laravel project
composer create-project laravel/laravel safari-tour-management

# Install required packages
composer require laravel/breeze --dev
composer require spatie/laravel-permission
composer require intervention/image
composer require maatwebsite/excel
composer require barryvdh/laravel-dompdf
composer require laravel/scout

# Install Breeze
php artisan breeze:install blade

# Install Permission package
php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"

# Run migrations
php artisan migrate
```

### 2.2 Migration Files

#### Migration 1: Users Table (Default Laravel)

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('phone')->nullable();
            $table->string('country')->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
            
            $table->index(['email', 'deleted_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
```

#### Migration 2: Create Roles, Permissions, and Related Tables (Spatie Package)

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Create roles table
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('guard_name')->default('web');
            $table->timestamps();
            
            $table->index(['name', 'guard_name']);
        });

        // Create permissions table
        Schema::create('permissions', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('guard_name')->default('web');
            $table->timestamps();
            
            $table->index(['name', 'guard_name']);
        });

        // Create model_has_permissions table
        Schema::create('model_has_permissions', function (Blueprint $table) {
            $table->unsignedBigInteger('permission_id');
            $table->string('model_type');
            $table->unsignedBigInteger('model_id');

            $table->primary(['permission_id', 'model_id', 'model_type']);
            $table->foreign('permission_id')->references('id')->on('permissions')->onDelete('cascade');
            $table->index(['model_id', 'model_type']);
        });

        // Create model_has_roles table
        Schema::create('model_has_roles', function (Blueprint $table) {
            $table->unsignedBigInteger('role_id');
            $table->string('model_type');
            $table->unsignedBigInteger('model_id');

            $table->primary(['role_id', 'model_id', 'model_type']);
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
            $table->index(['model_id', 'model_type']);
        });

        // Create role_has_permissions table
        Schema::create('role_has_permissions', function (Blueprint $table) {
            $table->unsignedBigInteger('permission_id');
            $table->unsignedBigInteger('role_id');

            $table->primary(['permission_id', 'role_id']);
            $table->foreign('permission_id')->references('id')->on('permissions')->onDelete('cascade');
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('role_has_permissions');
        Schema::dropIfExists('model_has_roles');
        Schema::dropIfExists('model_has_permissions');
        Schema::dropIfExists('permissions');
        Schema::dropIfExists('roles');
    }
};
```

#### Migration 3: Activity Logs Table

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->string('action');
            $table->text('description')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->json('old_values')->nullable();
            $table->json('new_values')->nullable();
            $table->timestamps();
            
            $table->index(['user_id', 'created_at']);
            $table->index('action');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
};
```

#### Migration 4: Enquiries Table

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('enquiries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('assigned_to')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('package_id')->nullable()->constrained('safari_packages')->onDelete('set null');
            $table->string('full_name');
            $table->string('email');
            $table->string('phone');
            $table->string('country');
            $table->integer('adults')->default(1);
            $table->integer('children')->default(0);
            $table->date('travel_date')->nullable();
            $table->integer('duration')->nullable();
            $table->string('budget')->nullable();
            $table->text('message')->nullable();
            $table->enum('status', ['new', 'contacted', 'quotation_sent', 'negotiation', 'confirmed', 'cancelled'])->default('new');
            $table->timestamp('last_contacted_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
            
            $table->index(['status', 'created_at']);
            $table->index('assigned_to');
            $table->index('package_id');
            $table->index('travel_date');
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('enquiries');
    }
};
```

#### Migration 5: Enquiry Notes Table

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('enquiry_notes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('enquiry_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->text('note');
            $table->boolean('is_internal')->default(true);
            $table->timestamps();
            
            $table->index('enquiry_id');
            $table->index('user_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('enquiry_notes');
    }
};
```

#### Migration 6: Enquiry Status History Table

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('enquiry_status_history', function (Blueprint $table) {
            $table->id();
            $table->foreignId('enquiry_id')->constrained()->onDelete('cascade');
            $table->string('status');
            $table->foreignId('changed_by')->constrained('users')->onDelete('cascade');
            $table->text('notes')->nullable();
            $table->timestamp('changed_at');
            
            $table->index('enquiry_id');
            $table->index('changed_by');
            $table->index('changed_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('enquiry_status_history');
    }
};
```

#### Migration 7: Follow Up Reminders Table

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('follow_up_reminders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('enquiry_id')->constrained()->onDelete('cascade');
            $table->date('reminder_date');
            $table->time('reminder_time')->nullable();
            $table->text('notes')->nullable();
            $table->enum('status', ['pending', 'sent', 'completed', 'cancelled'])->default('pending');
            $table->boolean('completed')->default(false);
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
            
            $table->index(['reminder_date', 'status']);
            $table->index('enquiry_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('follow_up_reminders');
    }
};
```

#### Migration 8: Package Categories Table

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('package_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('icon')->nullable();
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
            
            $table->index('slug');
            $table->index('is_active');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('package_categories');
    }
};
```

#### Migration 9: Safari Packages Table

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('safari_packages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->nullable()->constrained('package_categories')->onDelete('set null');
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('featured_image')->nullable();
            $table->string('short_desc', 500);
            $table->text('full_desc')->nullable();
            $table->integer('duration')->nullable()->comment('Duration in days');
            $table->decimal('price', 10, 2)->nullable();
            $table->string('currency', 3)->default('USD');
            $table->string('location')->nullable();
            $table->json('highlights')->nullable();
            $table->json('inclusions')->nullable();
            $table->json('exclusions')->nullable();
            $table->json('itinerary')->nullable();
            $table->json('pickup_dropoff')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_published')->default(false);
            $table->timestamp('published_at')->nullable();
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('meta_keywords')->nullable();
            $table->integer('views_count')->default(0);
            $table->integer('enquiries_count')->default(0);
            $table->timestamp('featured_until')->nullable();
            $table->timestamps();
            $table->softDeletes();
            
            $table->index(['is_published', 'published_at']);
            $table->index('is_featured');
            $table->index('category_id');
            $table->index('slug');
            $table->index('price');
            $table->index('duration');
            $table->index('location');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('safari_packages');
    }
};
```

#### Migration 10: Destinations Table

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('destinations', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('featured_image')->nullable();
            $table->string('country')->nullable();
            $table->string('region')->nullable();
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->string('best_time_to_visit')->nullable();
            $table->json('wildlife')->nullable();
            $table->json('activities')->nullable();
            $table->json('gallery')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->enum('status', ['active', 'inactive', 'archived'])->default('active');
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->integer('views_count')->default(0);
            $table->timestamps();
            
            $table->index('slug');
            $table->index('status');
            $table->index('is_featured');
            $table->index('country');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('destinations');
    }
};
```

#### Migration 11: Package Destination Pivot Table

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('package_destination', function (Blueprint $table) {
            $table->foreignId('package_id')->constrained('safari_packages')->onDelete('cascade');
            $table->foreignId('destination_id')->constrained('destinations')->onDelete('cascade');
            $table->integer('display_order')->default(0);
            
            $table->primary(['package_id', 'destination_id']);
            $table->index('package_id');
            $table->index('destination_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('package_destination');
    }
};
```

#### Migration 12: Package Gallery Table

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('package_gallery', function (Blueprint $table) {
            $table->id();
            $table->foreignId('package_id')->constrained('safari_packages')->onDelete('cascade');
            $table->string('image_path');
            $table->string('alt_text')->nullable();
            $table->string('caption')->nullable();
            $table->integer('display_order')->default(0);
            $table->boolean('is_featured')->default(false);
            $table->timestamps();
            
            $table->index('package_id');
            $table->index('display_order');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('package_gallery');
    }
};
```

#### Migration 13: Blog Categories Table

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('blog_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
            
            $table->index('slug');
            $table->index('is_active');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('blog_categories');
    }
};
```

#### Migration 14: Blog Tags Table

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('blog_tags', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('slug')->unique();
            $table->timestamps();
            
            $table->index('slug');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('blog_tags');
    }
};
```

#### Migration 15: Blog Posts Table

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('blog_posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->nullable()->constrained('blog_categories')->onDelete('set null');
            $table->foreignId('author_id')->constrained('users')->onDelete('cascade');
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('featured_image')->nullable();
            $table->text('content');
            $table->text('excerpt')->nullable();
            $table->boolean('is_published')->default(false);
            $table->boolean('allow_comments')->default(true);
            $table->timestamp('publish_date')->nullable();
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('meta_keywords')->nullable();
            $table->integer('views_count')->default(0);
            $table->timestamp('featured_until')->nullable();
            $table->timestamps();
            $table->softDeletes();
            
            $table->index(['is_published', 'publish_date']);
            $table->index('slug');
            $table->index('category_id');
            $table->index('author_id');
            $table->index('publish_date');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('blog_posts');
    }
};
```

#### Migration 16: Blog Post Tag Pivot Table

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('blog_post_tag', function (Blueprint $table) {
            $table->foreignId('post_id')->constrained('blog_posts')->onDelete('cascade');
            $table->foreignId('tag_id')->constrained('blog_tags')->onDelete('cascade');
            
            $table->primary(['post_id', 'tag_id']);
            $table->index('post_id');
            $table->index('tag_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('blog_post_tag');
    }
};
```

#### Migration 17: Blog Comments Table

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('blog_comments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('post_id')->constrained('blog_posts')->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->string('user_name')->nullable();
            $table->string('email')->nullable();
            $table->text('comment');
            $table->enum('status', ['pending', 'approved', 'rejected', 'spam'])->default('pending');
            $table->foreignId('parent_id')->nullable()->constrained('blog_comments')->onDelete('cascade');
            $table->timestamps();
            
            $table->index('post_id');
            $table->index('status');
            $table->index('user_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('blog_comments');
    }
};
```

#### Migration 18: Testimonials Table

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('testimonials', function (Blueprint $table) {
            $table->id();
            $table->foreignId('package_id')->nullable()->constrained('safari_packages')->onDelete('set null');
            $table->string('client_name');
            $table->string('country');
            $table->string('photo')->nullable();
            $table->text('review');
            $table->integer('rating')->default(5);
            $table->date('tour_date')->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->boolean('is_featured')->default(false);
            $table->timestamp('approved_at')->nullable();
            $table->timestamps();
            
            $table->index('package_id');
            $table->index('status');
            $table->index('is_featured');
            $table->index('rating');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('testimonials');
    }
};
```

#### Migration 19: Homepage Sections Table

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('homepage_sections', function (Blueprint $table) {
            $table->id();
            $table->enum('section_type', ['hero', 'featured_safaris', 'popular_destinations', 'testimonials', 'cta_section', 'stats', 'newsletter']);
            $table->string('title')->nullable();
            $table->text('subtitle')->nullable();
            $table->string('image_path')->nullable();
            $table->string('video_path')->nullable();
            $table->string('link_url')->nullable();
            $table->string('link_text')->nullable();
            $table->json('content')->nullable();
            $table->integer('display_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamp('active_from')->nullable();
            $table->timestamp('active_until')->nullable();
            $table->timestamps();
            
            $table->index('section_type');
            $table->index(['is_active', 'display_order']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('homepage_sections');
    }
};
```

#### Migration 20: Newsletter Subscribers Table

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('newsletter_subscribers', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique();
            $table->string('name')->nullable();
            $table->enum('status', ['active', 'unsubscribed', 'bounced'])->default('active');
            $table->timestamp('subscribed_at');
            $table->timestamp('unsubscribed_at')->nullable();
            $table->string('unsubscribe_token')->unique();
            $table->timestamps();
            
            $table->index('status');
            $table->index('email');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('newsletter_subscribers');
    }
};
```

#### Migration 21: Settings Table

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->string('type')->default('string');
            $table->string('group')->nullable();
            $table->text('description')->nullable();
            $table->boolean('is_public')->default(false);
            $table->timestamps();
            
            $table->index('key');
            $table->index('group');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
```

## 3. Database Seeders

### 3.1 Role and Permission Seeder

```php
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Create Roles
        $roles = [
            'super_admin',
            'admin',
            'content_manager',
            'sales_agent',
            'customer'
        ];

        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role]);
        }

        // Create Permissions
        $permissions = [
            // User Management
            'users.view',
            'users.create',
            'users.edit',
            'users.delete',
            'users.assign_roles',
            
            // Enquiry Management
            'enquiries.view',
            'enquiries.create',
            'enquiries.edit',
            'enquiries.delete',
            'enquiries.assign',
            'enquiries.export',
            
            // Package Management
            'packages.view',
            'packages.create',
            'packages.edit',
            'packages.delete',
            'packages.publish',
            
            // Destination Management
            'destinations.view',
            'destinations.create',
            'destinations.edit',
            'destinations.delete',
            
            // Blog Management
            'blog.view',
            'blog.create',
            'blog.edit',
            'blog.delete',
            'blog.publish',
            
            // Testimonial Management
            'testimonials.view',
            'testimonials.create',
            'testimonials.edit',
            'testimonials.delete',
            'testimonials.approve',
            
            // Homepage Management
            'homepage.view',
            'homepage.edit',
            
            // Settings
            'settings.view',
            'settings.edit',
            
            // Reports
            'reports.view',
            'reports.export',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Assign Permissions to Roles
        $superAdmin = Role::findByName('super_admin');
        $superAdmin->givePermissionTo(Permission::all());

        $admin = Role::findByName('admin');
        $admin->givePermissionTo([
            'users.view', 'users.create', 'users.edit', 'users.assign_roles',
            'enquiries.view', 'enquiries.create', 'enquiries.edit', 'enquiries.assign', 'enquiries.export',
            'packages.view', 'packages.create', 'packages.edit', 'packages.publish',
            'destinations.view', 'destinations.create', 'destinations.edit',
            'blog.view', 'blog.create', 'blog.edit', 'blog.publish',
            'testimonials.view', 'testimonials.create', 'testimonials.edit', 'testimonials.approve',
            'homepage.view', 'homepage.edit',
            'reports.view', 'reports.export'
        ]);

        $contentManager = Role::findByName('content_manager');
        $contentManager->givePermissionTo([
            'packages.view', 'packages.create', 'packages.edit', 'packages.publish',
            'destinations.view', 'destinations.create', 'destinations.edit',
            'blog.view', 'blog.create', 'blog.edit', 'blog.publish',
            'testimonials.view', 'testimonials.create', 'testimonials.edit', 'testimonials.approve',
            'homepage.view', 'homepage.edit'
        ]);

        $salesAgent = Role::findByName('sales_agent');
        $salesAgent->givePermissionTo([
            'enquiries.view',
            'enquiries.edit',
            'enquiries.create'
        ]);

        $customer = Role::findByName('customer');
        $customer->givePermissionTo([
            'enquiries.create'
        ]);
    }
}
```

### 3.2 Settings Seeder

```php
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingsSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            // General Settings
            ['key' => 'site_name', 'value' => 'Safari Tours', 'type' => 'string', 'group' => 'general', 'is_public' => true],
            ['key' => 'site_description', 'value' => 'Experience the magic of African safaris', 'type' => 'text', 'group' => 'general', 'is_public' => true],
            ['key' => 'site_logo', 'value' => null, 'type' => 'image', 'group' => 'general', 'is_public' => true],
            ['key' => 'site_favicon', 'value' => null, 'type' => 'image', 'group' => 'general', 'is_public' => true],
            
            // Contact Settings
            ['key' => 'contact_email', 'value' => 'info@safaritours.com', 'type' => 'string', 'group' => 'contact', 'is_public' => true],
            ['key' => 'contact_phone', 'value' => '+254 700 000 000', 'type' => 'string', 'group' => 'contact', 'is_public' => true],
            ['key' => 'contact_address', 'value' => 'Nairobi, Kenya', 'type' => 'text', 'group' => 'contact', 'is_public' => true],
            
            // Social Media
            ['key' => 'facebook_url', 'value' => null, 'type' => 'string', 'group' => 'social', 'is_public' => true],
            ['key' => 'twitter_url', 'value' => null, 'type' => 'string', 'group' => 'social', 'is_public' => true],
            ['key' => 'instagram_url', 'value' => null, 'type' => 'string', 'group' => 'social', 'is_public' => true],
            ['key' => 'youtube_url', 'value' => null, 'type' => 'string', 'group' => 'social', 'is_public' => true],
            
            // Email Settings
            ['key' => 'mail_from_address', 'value' => 'noreply@safaritours.com', 'type' => 'string', 'group' => 'email', 'is_public' => false],
            ['key' => 'mail_from_name', 'value' => 'Safari Tours', 'type' => 'string', 'group' => 'email', 'is_public' => false],
            
            // SEO Settings
            ['key' => 'meta_title_default', 'value' => 'Safari Tours - Experience Africa', 'type' => 'string', 'group' => 'seo', 'is_public' => true],
            ['key' => 'meta_description_default', 'value' => 'Book your dream African safari with us. Experience wildlife, culture, and adventure.', 'type' => 'text', 'group' => 'seo', 'is_public' => true],
        ];

        foreach ($settings as $setting) {
            Setting::firstOrCreate(['key' => $setting['key']], $setting);
        }
    }
}
```

### 3.3 Package Categories Seeder

```php
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PackageCategory;

class PackageCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Budget Safaris', 'slug' => 'budget-safaris', 'description' => 'Affordable safari options for budget-conscious travelers', 'sort_order' => 1],
            ['name' => 'Mid-Range Safaris', 'slug' => 'mid-range-safaris', 'description' => 'Comfortable safari experiences at reasonable prices', 'sort_order' => 2],
            ['name' => 'Luxury Safaris', 'slug' => 'luxury-safaris', 'description' => 'Premium safari experiences with luxury accommodations', 'sort_order' => 3],
            ['name' => 'Family Safaris', 'slug' => 'family-safaris', 'description' => 'Family-friendly safari packages suitable for all ages', 'sort_order' => 4],
            ['name' => 'Honeymoon Safaris', 'slug' => 'honeymoon-safaris', 'description' => 'Romantic safari experiences for couples', 'sort_order' => 5],
            ['name' => 'Adventure Safaris', 'slug' => 'adventure-safaris', 'description' => 'Thrilling adventure activities combined with wildlife viewing', 'sort_order' => 6],
        ];

        foreach ($categories as $category) {
            PackageCategory::firstOrCreate(['slug' => $category['slug']], $category);
        }
    }
}
```

## 4. Eloquent Models

### 4.1 User Model

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens, HasRoles, SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'country',
        'email_verified_at'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // Relationships
    public function enquiries()
    {
        return $this->hasMany(Enquiry::class);
    }

    public function assignedEnquiries()
    {
        return $this->hasMany(Enquiry::class, 'assigned_to');
    }

    public function enquiryNotes()
    {
        return $this->hasMany(EnquiryNote::class);
    }

    public function activityLogs()
    {
        return $this->hasMany(ActivityLog::class);
    }

    public function blogPosts()
    {
        return $this->hasMany(BlogPost::class, 'author_id');
    }

    public function statusChanges()
    {
        return $this->hasMany(EnquiryStatusHistory::class, 'changed_by');
    }
}
```

### 4.2 Enquiry Model

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Enquiry extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'assigned_to',
        'package_id',
        'full_name',
        'email',
        'phone',
        'country',
        'adults',
        'children',
        'travel_date',
        'duration',
        'budget',
        'message',
        'status',
        'last_contacted_at'
    ];

    protected $casts = [
        'travel_date' => 'date',
        'last_contacted_at' => 'datetime',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function assignedTo()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function package()
    {
        return $this->belongsTo(SafariPackage::class);
    }

    public function notes()
    {
        return $this->hasMany(EnquiryNote::class);
    }

    public function statusHistory()
    {
        return $this->hasMany(EnquiryStatusHistory::class);
    }

    public function reminders()
    {
        return $this->hasMany(FollowUpReminder::class);
    }

    // Scopes
    public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function scopeAssignedTo($query, $userId)
    {
        return $query->where('assigned_to', $userId);
    }
}
```

### 4.3 SafariPackage Model

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class SafariPackage extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'category_id',
        'title',
        'slug',
        'featured_image',
        'short_desc',
        'full_desc',
        'duration',
        'price',
        'currency',
        'location',
        'highlights',
        'inclusions',
        'exclusions',
        'itinerary',
        'pickup_dropoff',
        'is_featured',
        'is_published',
        'published_at',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'views_count',
        'enquiries_count',
        'featured_until'
    ];

    protected $casts = [
        'highlights' => 'array',
        'inclusions' => 'array',
        'exclusions' => 'array',
        'itinerary' => 'array',
        'pickup_dropoff' => 'array',
        'published_at' => 'datetime',
        'featured_until' => 'datetime',
    ];

    // Relationships
    public function category()
    {
        return $this->belongsTo(PackageCategory::class);
    }

    public function destinations()
    {
        return $this->belongsToMany(Destination::class, 'package_destination')
                    ->withPivot('display_order')
                    ->orderBy('display_order');
    }

    public function gallery()
    {
        return $this->hasMany(PackageGallery::class)->orderBy('display_order');
    }

    public function enquiries()
    {
        return $this->hasMany(Enquiry::class);
    }

    public function testimonials()
    {
        return $this->hasMany(Testimonial::class);
    }

    // Scopes
    public function scopePublished($query)
    {
        return $query->where('is_published', true)
                     ->where('published_at', '<=', now());
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true)
                     ->where(function($q) {
                         $q->whereNull('featured_until')
                           ->orWhere('featured_until', '>', now());
                     });
    }
}
```

### 4.4 Destination Model

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Destination extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'featured_image',
        'country',
        'region',
        'latitude',
        'longitude',
        'best_time_to_visit',
        'wildlife',
        'activities',
        'gallery',
        'is_featured',
        'status',
        'meta_title',
        'meta_description',
        'views_count'
    ];

    protected $casts = [
        'wildlife' => 'array',
        'activities' => 'array',
        'gallery' => 'array',
    ];

    // Relationships
    public function packages()
    {
        return $this->belongsToMany(SafariPackage::class, 'package_destination')
                    ->withPivot('display_order')
                    ->orderBy('display_order');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }
}
```

### 4.5 BlogPost Model

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class BlogPost extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'category_id',
        'author_id',
        'title',
        'slug',
        'featured_image',
        'content',
        'excerpt',
        'is_published',
        'allow_comments',
        'publish_date',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'views_count',
        'featured_until'
    ];

    protected $casts = [
        'publish_date' => 'datetime',
        'featured_until' => 'datetime',
    ];

    // Relationships
    public function category()
    {
        return $this->belongsTo(BlogCategory::class);
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function tags()
    {
        return $this->belongsToMany(BlogTag::class, 'blog_post_tag');
    }

    public function comments()
    {
        return $this->hasMany(BlogComment::class)->whereNull('parent_id');
    }

    // Scopes
    public function scopePublished($query)
    {
        return $query->where('is_published', true)
                     ->where('publish_date', '<=', now());
    }
}
```

## 5. Database Configuration

### 5.1 .env Configuration

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=safari_tours
DB_USERNAME=root
DB_PASSWORD=

# For production use:
# DB_CONNECTION=mysql
# DB_HOST=your-production-host
# DB_PORT=3306
# DB_DATABASE=safari_tours_production
# DB_USERNAME=your-username
# DB_PASSWORD=your-secure-password
```

### 5.2 config/database.php

```php
'mysql' => [
    'driver' => 'mysql',
    'url' => env('DATABASE_URL'),
    'host' => env('DB_HOST', '127.0.0.1'),
    'port' => env('DB_PORT', '3306'),
    'database' => env('DB_DATABASE', 'forge'),
    'username' => env('DB_USERNAME', 'forge'),
    'password' => env('DB_PASSWORD', ''),
    'unix_socket' => env('DB_SOCKET', ''),
    'charset' => 'utf8mb4',
    'collation' => 'utf8mb4_unicode_ci',
    'prefix' => '',
    'prefix_indexes' => true,
    'strict' => true,
    'engine' => null,
    'options' => extension_loaded('pdo_mysql') ? array_filter([
        PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
    ]) : [],
],
```

## 6. Running Migrations

```bash
# Run all migrations
php artisan migrate

# Run specific migration
php artisan migrate --path=database/migrations/2024_01_01_000000_create_users_table.php

# Rollback last migration
php artisan migrate:rollback

# Rollback all migrations
php artisan migrate:reset

# Rollback and re-run all migrations
php artisan migrate:refresh

# Run seeders
php artisan db:seed

# Fresh migration with seeding
php artisan migrate:fresh --seed
```

## 7. Database Backup Strategy

### 7.1 Manual Backup

```bash
# Backup entire database
mysqldump -u root -p safari_tours > backup_$(date +%Y%m%d).sql

# Backup specific tables
mysqldump -u root -p safari_tours users enquiries > tables_backup.sql

# Restore database
mysql -u root -p safari_tours < backup_20240101.sql
```

### 7.2 Automated Backup Script

```bash
#!/bin/bash
# backup_database.sh

DB_NAME="safari_tours"
DB_USER="root"
DB_PASS=""
BACKUP_DIR="/var/backups/mysql"
DATE=$(date +%Y%m%d_%H%M%S)

# Create backup directory if it doesn't exist
mkdir -p $BACKUP_DIR

# Backup database
mysqldump -u $DB_USER -p$DB_PASS $DB_NAME > $BACKUP_DIR/${DB_NAME}_${DATE}.sql

# Compress backup
gzip $BACKUP_DIR/${DB_NAME}_${DATE}.sql

# Delete backups older than 30 days
find $BACKUP_DIR -name "${DB_NAME}_*.sql.gz" -mtime +30 -delete

echo "Backup completed: ${DB_NAME}_${DATE}.sql.gz"
```

### 7.3 Laravel Backup Package

Install and configure Laravel Backup:

```bash
composer require spatie/laravel-backup
php artisan vendor:publish --provider="Spatie\Backup\BackupServiceProvider"
```

Configuration in `config/backup.php`:

```php
'backup' => [
    'name' => env('APP_NAME', 'laravel-backup'),
    'source' => [
        'files' => [
            'include' => [
                base_path(),
            ],
            'exclude' => [
                base_path('vendor'),
                base_path('node_modules'),
            ],
        ],
        'databases' => [
            'mysql',
        ],
    ],
    'database_dump_compressor' => null,
    'destination' => [
        'filename_prefix' => '',
        'disks' => [
            'local',
        ],
    ],
],
```

## 8. Performance Optimization

### 8.1 Indexing Strategy

All critical foreign keys and frequently queried columns are indexed:
- Foreign key columns
- Status columns
- Date columns (created_at, published_at, travel_date)
- Slug columns for URL routing
- Composite indexes for common query patterns

### 8.2 Query Optimization

```php
// Use eager loading to prevent N+1 queries
$packages = SafariPackage::with(['category', 'destinations', 'gallery'])
                         ->published()
                         ->featured()
                         ->get();

// Use select to limit columns
$packages = SafariPackage::select('id', 'title', 'slug', 'price', 'featured_image')
                         ->published()
                         ->get();

// Use pagination for large datasets
$enquiries = Enquiry::with(['user', 'assignedTo', 'package'])
                    ->where('assigned_to', auth()->id())
                    ->paginate(20);
```

This complete database schema provides a solid foundation for the Safari Tour Management System with proper relationships, indexing, and optimization strategies.