# Safari Tour Management System - ERD Diagram Documentation

## 1. Entity Relationship Diagram Overview

The database design for the Safari Tour Management System follows a normalized relational database structure with proper relationships, constraints, and indexing for optimal performance.

## 2. ERD Diagram (ASCII Representation)

```
┌─────────────────────────────────────────────────────────────────────────────────────────────────┐
│                          SAFARI TOUR MANAGEMENT SYSTEM ERD                                    │
└─────────────────────────────────────────────────────────────────────────────────────────────────┘

    ┌─────────────────┐         ┌─────────────────┐         ┌─────────────────┐
    │     USERS      │         │     ROLES       │         │  PERMISSIONS    │
    ├─────────────────┤         ├─────────────────┤         ├─────────────────┤
    │ id (PK)        │────┐    │ id (PK)        │         │ id (PK)        │
    │ name           │    │    │ name           │         │ name           │
    │ email          │    │    │ guard_name     │         │ guard_name     │
    │ email_verified │    │    └─────────────────┘         └─────────────────┘
    │ password       │    │
    │ remember_token │    │         ┌─────────────────┐         ┌─────────────────┐
    │ created_at     │    │         │ ROLE_HAS_       │         │ MODEL_HAS_      │
    │ updated_at     │    │         │ PERMISSIONS     │         │ PERMISSIONS     │
    │ deleted_at     │    │         ├─────────────────┤         ├─────────────────┤
    └─────────────────┘    │         │ role_id (PK,FK) │         │ permission_id   │────┐
                           │         │ permission_id   │────┐    │ model_type      │   │
                           │         │ (PK,FK)         │    │    │ model_id        │   │
                           │         └─────────────────┘    │    └─────────────────┘   │
                           │                                │                          │
                           │    ┌─────────────────┐         │    ┌─────────────────┐   │
                           │    │ MODEL_HAS_ROLES │         │    │ ACTIVITY_LOGS    │   │
                           │    ├─────────────────┤         │    ├─────────────────┤   │
                           │    │ role_id (PK,FK) │         │    │ id (PK)        │   │
                           └───→│ model_type      │         │    │ user_id (FK)    │───┘
                                │ model_id        │         │    │ action         │
                                │ (PK)            │         │    │ description    │
                                └─────────────────┘         │    │ ip_address     │
                                                             │    │ user_agent     │
                                                             │    │ created_at     │
                                                             │    └─────────────────┘
                                                                             │
                                                                             │
                          ┌─────────────────────────────────────────────────┘
                          │
    ┌────────────────────────────────────────────────────────────────────────────────┐
    │                         ENQUIRY MANAGEMENT                                      │
    ├────────────────────────────────────────────────────────────────────────────────┤
    │                                                                                │
    │    ┌─────────────────┐         ┌─────────────────┐         ┌─────────────────┐ │
    │    │   ENQUIRIES     │         │ ENQUIRY_NOTES   │         │ENQUIRY_STATUS   │ │
    │    ├─────────────────┤         ├─────────────────┤         │   _HISTORY      │ │
    │    │ id (PK)         │──┐      │ id (PK)         │         ├─────────────────┤ │
    │    │ user_id (FK)    │  │      │ enquiry_id (FK) │←──────│ id (PK)        │ │
    │    │ assigned_to (FK)│──┼──┐   │ user_id (FK)    │        │ enquiry_id (FK) │ │
    │    │ package_id (FK) │  │  │   │ note            │        │ status         │ │
    │    │ full_name       │  │  │   │ is_internal     │        │ changed_by (FK) │ │
    │    │ email           │  │  │   │ created_at     │        │ changed_at     │ │
    │    │ phone           │  │  │   └─────────────────┘        └─────────────────┘ │
    │    │ country         │  │  │                                            │       │
    │    │ adults          │  │  │                                            │       │
    │    │ children        │  │  │         ┌─────────────────┐                    │       │
    │    │ travel_date     │  │  │         │FOLLOW_UP_REMIND │                    │       │
    │    │ duration        │  │  │         ├─────────────────┤                    │       │
    │    │ budget          │  │  │         │ id (PK)        │                    │       │
    │    │ message         │  │  │         │ enquiry_id (FK) │←───────────────────┘       │
    │    │ status          │  │  │         │ reminder_date  │                            │
    │    │ created_at      │  │  │         │ reminder_time  │                            │
    │    │ updated_at      │  │  │         │ notes          │                            │
    │    └─────────────────┘  │  │         │ status         │                            │
    │                         │  │         │ completed      │                            │
    │                         │  │         │ created_at     │                            │
    │                         │  │         └─────────────────┘                            │
    │                         │  │                                                      │
    │                         │  │                                                      │
    │                         │  └──────────────────────────────────────────────────────┘
    │                         │
    │                         └──────────────────┐
    │                                            │
    └────────────────────────────────────────────┼────────────────────────────────────────┘
                                                 │
                                                 │ (FK)
                                                 │
    ┌────────────────────────────────────────────┼────────────────────────────────────────┐
    │                         CONTENT MANAGEMENT                                     │    │
    ├────────────────────────────────────────────┼────────────────────────────────────────┤    │
    │                                             │                                       │    │
    │    ┌─────────────────┐          ┌──────────┼─────────┐     ┌─────────────────┐      │    │
    │    │ SAFARI_PACKAGES │          │PACKAGE_  │DESTINATI │     │   DESTINATIONS  │      │    │
    │    ├─────────────────┤          │CATEGORIES│_ON       │     ├─────────────────┤      │    │
    │    │ id (PK)        │          ├──────────┼─────────┤     │ id (PK)        │      │    │
    │    │ category_id(FK)│─────────→│package_id│destination│←───│ name           │      │    │
    │    │ title          │          │(PK,FK)   │_id (PK,FK)│    │ slug           │      │    │
    │    │ slug           │          │          │         │     │ description    │      │    │
    │    │ featured_image │          └──────────┴─────────┘     │ featured_image │      │    │
    │    │ short_desc     │                                    │ country        │      │    │
    │    │ full_desc      │                                    │ region         │      │    │
    │    │ duration       │                                    │ latitude       │      │    │
    │    │ price          │          ┌─────────────────┐      │ longitude      │      │    │
    │    │ location       │          │PACKAGE_GALLERY  │      │ best_time      │      │    │
    │    │ is_featured    │          ├─────────────────┤      │ wildlife       │      │    │
    │    │ is_published   │          │ id (PK)        │      │ activities     │      │    │
    │    │ meta_title     │          │ package_id (FK) │      │ seo_title      │      │    │
    │    │ meta_desc      │          │ image_path     │      │ seo_desc       │      │    │
    │    │ created_at     │          │ alt_text       │      │ status         │      │    │
    │    │ updated_at     │          │ display_order  │      │ created_at     │      │    │
    │    │ deleted_at     │          │ created_at     │      │ updated_at     │      │    │
    │    └─────────────────┘          └─────────────────┘      └─────────────────┘      │    │
    │                                                                                │    │
    │    ┌─────────────────┐          ┌─────────────────┐      ┌─────────────────┐      │    │
    │    │ BLOG_POSTS      │          │ BLOG_CATEGORIES │      │    BLOG_TAGS    │      │    │
    │    ├─────────────────┤          ├─────────────────┤      ├─────────────────┤      │    │
    │    │ id (PK)        │          │ id (PK)        │      │ id (PK)        │      │    │
    │    │ category_id(FK) │─────────→│ name           │      │ name           │      │    │
    │    │ author_id (FK)  │          │ slug           │      │ slug           │      │    │
    │    │ title          │          │ description    │      └─────────────────┘      │    │
    │    │ slug           │          └─────────────────┘                               │    │
    │    │ featured_image │                                                        │    │
    │    │ content        │          ┌─────────────────┐      ┌─────────────────┐      │    │
    │    │ is_published   │          │ BLOG_POST_TAG   │      │  BLOG_COMMENTS  │      │    │
    │    │ allow_comments │          ├─────────────────┤      ├─────────────────┤      │    │
    │    │ publish_date   │          │ post_id (PK,FK) │      │ id (PK)        │      │    │
    │    │ meta_title     │          │ tag_id (PK,FK)  │      │ post_id (FK)    │      │    │
    │    │ meta_desc      │          └─────────────────┘      │ user_name      │      │    │
    │    │ created_at     │                                    │ email          │      │    │
    │    │ updated_at     │                                    │ comment        │      │    │
    │    │ deleted_at     │                                    │ status         │      │    │
    │    └─────────────────┘                                    │ created_at     │      │    │
    │                                                           │ updated_at     │      │    │
    │    ┌─────────────────┐                                   └─────────────────┘      │    │
    │    │  TESTIMONIALS   │                                                            │    │
    │    ├─────────────────┤                                                            │    │
    │    │ id (PK)        │                                                            │    │
    │    │ package_id (FK) │──────────────────────────────────────────────────────────┘    │
    │    │ client_name    │                                                                 │
    │    │ country        │                                                                 │
    │    │ photo          │                                                                 │
    │    │ review         │                                                                 │
    │    │ rating         │                                                                 │
    │    │ tour_date      │                                                                 │
    │    │ status         │                                                                 │
    │    │ is_featured    │                                                                 │
    │    │ created_at     │                                                                 │
    │    │ updated_at     │                                                                 │
    │    └─────────────────┘                                                                 │
    │                                                                                         │
    └─────────────────────────────────────────────────────────────────────────────────────────┘
                                                 │
                                                 │
    ┌────────────────────────────────────────────┼────────────────────────────────────────┐
    │                    HOMEPAGE & SETTINGS                                │    │
    ├────────────────────────────────────────────┼────────────────────────────────────────┤    │
    │                                             │                                       │    │
    │    ┌─────────────────┐          ┌──────────┼─────────┐     ┌─────────────────┐      │    │
    │    │ HOMEPAGE_       │          │NEWSLETTER│ SETTINGS │     │   PASSWORD_     │      │    │
    │    │ SECTIONS        │          │_SUBSCRIB │         │     │   RESET_TOKENS  │      │    │
    │    ├─────────────────┤          │   ERS    ├─────────┤     ├─────────────────┤      │    │
    │    │ id (PK)        │          ├──────────┼─────────┤     │ id (PK)        │      │    │
    │    │ section_type   │          │ id (PK)  │ key     │     │ email          │      │    │
    │    │ title          │          │ email    │ value   │     │ token          │      │    │
    │    │ subtitle       │          │ status   │ type    │     │ created_at     │      │    │
    │    │ image_path     │          │ created_ │updated_ │     └─────────────────┘      │    │
    │    │ link_url       │          │ at       │at       │                               │    │
    │    │ link_text      │          └──────────┴─────────┘     ┌─────────────────┐      │    │
    │    │ display_order  │                                    │   PERSONAL_    │      │    │
    │    │ is_active     │                                    │   ACCESS_      │      │    │
    │    │ created_at     │                                    │   TOKENS       │      │    │
    │    │ updated_at     │                                    ├─────────────────┤      │    │
    │    └─────────────────┘                                    │ id (PK)        │      │    │
    │                                                           │ tokenable_type │      │    │
    │                                                           │ tokenable_id   │      │    │
    │                                                           │ name           │      │    │
    │                                                           │ token          │      │    │
    │                                                           │ abilities      │      │    │
    │                                                           │ last_used_at   │      │    │
    │                                                           │ expires_at     │      │    │
    │                                                           │ created_at     │      │    │
    │                                                           └─────────────────┘      │    │
    │                                                                                      │    │
    └─────────────────────────────────────────────────────────────────────────────────────┘    │
                                                                                               │
                                                                                                │
    ┌────────────────────────────────────────────────────────────────────────────────────────────┘
    │
    │
    ┌────────────────────────────────────────────────────────────────────────────────────────────┐
    │                    LARAVEL SYSTEM TABLES                                                    │
    ├────────────────────────────────────────────────────────────────────────────────────────────┤
    │                                                                                            │
    │    ┌─────────────────┐          ┌─────────────────┐          ┌─────────────────┐          │
    │    │     JOBS        │          │   FAILED_JOBS   │          │    MIGRATIONS   │          │
    │    ├─────────────────┤          ├─────────────────┤          ├─────────────────┤          │
    │    │ id (PK)        │          │ id (PK)        │          │ id (PK)        │          │
    │    │ queue          │          │ uuid           │          │ migration      │          │
    │    │ payload        │          │ connection     │          │ batch          │          │
    │    │ attempts       │          │ queue          │          └─────────────────┘          │
    │    │ reserved_at    │          │ payload        │                                           │
    │    │ available_at   │          │ exception      │    ┌─────────────────┐                  │
    │    │ created_at     │          │ failed_at      │    │     SESSIONS    │                  │
    │    └─────────────────┘          └─────────────────┘    ├─────────────────┤                  │
    │                                                   │    │ id (PK)        │                  │
    │                                                   │    │ user_id (FK)   │                  │
    │                                                   │    │ ip_address     │                  │
    │                                                   │    │ user_agent     │                  │
    │                                                   │    │ payload        │                  │
    │                                                   │    │ last_activity  │                  │
    │                                                   │    └─────────────────┘                  │
    │                                                   │                                           │
    └───────────────────────────────────────────────────┴───────────────────────────────────────────┘
```

## 3. Entity Definitions

### 3.1 Users Table
**Purpose**: Store user account information and authentication credentials

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| id | BIGINT UNSIGNED | PK, AI | Unique identifier |
| name | VARCHAR(255) | NOT NULL | Full name |
| email | VARCHAR(255) | UNIQUE, NOT NULL | Email address |
| email_verified_at | TIMESTAMP | NULLABLE | Email verification timestamp |
| password | VARCHAR(255) | NOT NULL | Encrypted password |
| remember_token | VARCHAR(100) | NULLABLE | Remember me token |
| created_at | TIMESTAMP | NOT NULL | Record creation time |
| updated_at | TIMESTAMP | NOT NULL | Record update time |
| deleted_at | TIMESTAMP | NULLABLE | Soft delete timestamp |

**Relationships**:
- HasMany: Enquiries (as user)
- HasMany: EnquiryNotes
- HasMany: ActivityLogs
- HasMany: BlogPosts (as author)
- BelongsToMany: Roles (via model_has_roles)
- BelongsToMany: Permissions (via model_has_permissions)

### 3.2 Roles Table
**Purpose**: Define user roles for authorization

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| id | BIGINT UNSIGNED | PK, AI | Unique identifier |
| name | VARCHAR(255) | UNIQUE, NOT NULL | Role name |
| guard_name | VARCHAR(255) | NOT NULL | Guard name (default: web) |

**Predefined Roles**:
- super_admin
- admin
- content_manager
- sales_agent
- customer

**Relationships**:
- BelongsToMany: Users (via model_has_roles)
- BelongsToMany: Permissions (via role_has_permissions)

### 3.3 Permissions Table
**Purpose**: Define system permissions

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| id | BIGINT UNSIGNED | PK, AI | Unique identifier |
| name | VARCHAR(255) | UNIQUE, NOT NULL | Permission name |
| guard_name | VARCHAR(255) | NOT NULL | Guard name (default: web) |

**Sample Permissions**:
- users.create, users.read, users.update, users.delete
- enquiries.create, enquiries.read, enquiries.update, enquiries.delete
- packages.create, packages.read, packages.update, packages.delete
- blogs.create, blogs.read, blogs.update, blogs.delete
- destinations.create, destinations.read, destinations.update, destinations.delete

**Relationships**:
- BelongsToMany: Roles (via role_has_permissions)
- BelongsToMany: Users (via model_has_permissions)

### 3.4 Enquiries Table
**Purpose**: Store safari tour enquiries from customers

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| id | BIGINT UNSIGNED | PK, AI | Unique identifier |
| user_id | BIGINT UNSIGNED | FK, NULLABLE | Customer user ID |
| assigned_to | BIGINT UNSIGNED | FK, NULLABLE | Sales agent user ID |
| package_id | BIGINT UNSIGNED | FK, NULLABLE | Interested package |
| full_name | VARCHAR(255) | NOT NULL | Customer full name |
| email | VARCHAR(255) | NOT NULL | Customer email |
| phone | VARCHAR(50) | NOT NULL | Customer phone number |
| country | VARCHAR(100) | NOT NULL | Customer country |
| adults | INT | NOT NULL, DEFAULT 1 | Number of adults |
| children | INT | NOT NULL, DEFAULT 0 | Number of children |
| travel_date | DATE | NULLABLE | Preferred travel date |
| duration | INT | NULLABLE | Tour duration (days) |
| budget | VARCHAR(50) | NULLABLE | Budget range |
| message | TEXT | NULLABLE | Customer message |
| status | ENUM | NOT NULL | Enquiry status |
| created_at | TIMESTAMP | NOT NULL | Record creation time |
| updated_at | TIMESTAMP | NOT NULL | Record update time |

**Status Enum Values**: new, contacted, quotation_sent, negotiation, confirmed, cancelled

**Relationships**:
- BelongsTo: User (as customer)
- BelongsTo: User (as assigned_to - Sales Agent)
- BelongsTo: SafariPackage
- HasMany: EnquiryNotes
- HasMany: EnquiryStatusHistory
- HasMany: FollowUpReminders

### 3.5 EnquiryNotes Table
**Purpose**: Store internal notes for enquiries

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| id | BIGINT UNSIGNED | PK, AI | Unique identifier |
| enquiry_id | BIGINT UNSIGNED | FK, NOT NULL | Related enquiry |
| user_id | BIGINT UNSIGNED | FK, NOT NULL | Note author |
| note | TEXT | NOT NULL | Note content |
| is_internal | BOOLEAN | NOT NULL, DEFAULT TRUE | Internal only flag |
| created_at | TIMESTAMP | NOT NULL | Record creation time |

**Relationships**:
- BelongsTo: Enquiry
- BelongsTo: User

### 3.6 EnquiryStatusHistory Table
**Purpose**: Track enquiry status changes

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| id | BIGINT UNSIGNED | PK, AI | Unique identifier |
| enquiry_id | BIGINT UNSIGNED | FK, NOT NULL | Related enquiry |
| status | VARCHAR(50) | NOT NULL | New status |
| changed_by | BIGINT UNSIGNED | FK, NOT NULL | User who changed |
| changed_at | TIMESTAMP | NOT NULL | Change timestamp |

**Relationships**:
- BelongsTo: Enquiry
- BelongsTo: User

### 3.7 FollowUpReminders Table
**Purpose**: Store follow-up reminders for enquiries

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| id | BIGINT UNSIGNED | PK, AI | Unique identifier |
| enquiry_id | BIGINT UNSIGNED | FK, NOT NULL | Related enquiry |
| reminder_date | DATE | NOT NULL | Reminder date |
| reminder_time | TIME | NULLABLE | Reminder time |
| notes | TEXT | NULLABLE | Reminder notes |
| status | ENUM | NOT NULL, DEFAULT pending | Reminder status |
| completed | BOOLEAN | NOT NULL, DEFAULT FALSE | Completion flag |
| created_at | TIMESTAMP | NOT NULL | Record creation time |

**Status Enum Values**: pending, sent, completed, cancelled

**Relationships**:
- BelongsTo: Enquiry

### 3.8 SafariPackages Table
**Purpose**: Store safari package information

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| id | BIGINT UNSIGNED | PK, AI | Unique identifier |
| category_id | BIGINT UNSIGNED | FK, NULLABLE | Package category |
| title | VARCHAR(255) | NOT NULL, UNIQUE | Package title |
| slug | VARCHAR(255) | NOT NULL, UNIQUE | URL slug |
| featured_image | VARCHAR(255) | NULLABLE | Main image path |
| short_desc | VARCHAR(500) | NOT NULL | Short description |
| full_desc | TEXT | NULLABLE | Full description |
| duration | INT | NULLABLE | Duration in days |
| price | DECIMAL(10,2) | NULLABLE | Package price |
| location | VARCHAR(255) | NULLABLE | Location/destination |
| highlights | JSON | NULLABLE | Package highlights (array) |
| inclusions | JSON | NULLABLE | Inclusions (array) |
| exclusions | JSON | NULLABLE | Exclusions (array) |
| itinerary | JSON | NULLABLE | Day-by-day itinerary |
| is_featured | BOOLEAN | NOT NULL, DEFAULT FALSE | Featured package flag |
| is_published | BOOLEAN | NOT NULL, DEFAULT FALSE | Published flag |
| meta_title | VARCHAR(255) | NULLABLE | SEO meta title |
| meta_desc | TEXT | NULLABLE | SEO meta description |
| created_at | TIMESTAMP | NOT NULL | Record creation time |
| updated_at | TIMESTAMP | NOT NULL | Record update time |
| deleted_at | TIMESTAMP | NULLABLE | Soft delete timestamp |

**Relationships**:
- BelongsTo: PackageCategory
- BelongsToMany: Destination (via package_destination)
- HasMany: PackageGallery
- HasMany: Enquiries
- HasMany: Testimonials

### 3.9 PackageCategories Table
**Purpose**: Define package categories

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| id | BIGINT UNSIGNED | PK, AI | Unique identifier |
| name | VARCHAR(255) | NOT NULL, UNIQUE | Category name |
| slug | VARCHAR(255) | NOT NULL, UNIQUE | URL slug |
| description | TEXT | NULLABLE | Category description |
| icon | VARCHAR(255) | NULLABLE | Category icon |
| created_at | TIMESTAMP | NOT NULL | Record creation time |
| updated_at | TIMESTAMP | NOT NULL | Record update time |

**Predefined Categories**:
- Budget Safaris
- Mid-Range Safaris
- Luxury Safaris
- Family Safaris
- Honeymoon Safaris
- Adventure Safaris

**Relationships**:
- HasMany: SafariPackages

### 3.10 Destinations Table
**Purpose**: Store destination information

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| id | BIGINT UNSIGNED | PK, AI | Unique identifier |
| name | VARCHAR(255) | NOT NULL, UNIQUE | Destination name |
| slug | VARCHAR(255) | NOT NULL, UNIQUE | URL slug |
| description | TEXT | NULLABLE | Destination description |
| featured_image | VARCHAR(255) | NULLABLE | Main image path |
| country | VARCHAR(100) | NULLABLE | Country |
| region | VARCHAR(100) | NULLABLE | Region |
| latitude | DECIMAL(10,8) | NULLABLE | GPS latitude |
| longitude | DECIMAL(11,8) | NULLABLE | GPS longitude |
| best_time | VARCHAR(255) | NULLABLE | Best time to visit |
| wildlife | JSON | NULLABLE | Wildlife highlights (array) |
| activities | JSON | NULLABLE | Activities (array) |
| is_featured | BOOLEAN | NOT NULL, DEFAULT FALSE | Featured flag |
| seo_title | VARCHAR(255) | NULLABLE | SEO meta title |
| seo_desc | TEXT | NULLABLE | SEO meta description |
| status | ENUM | NOT NULL, DEFAULT active | Status |
| created_at | TIMESTAMP | NOT NULL | Record creation time |
| updated_at | TIMESTAMP | NOT NULL | Record update time |

**Status Enum Values**: active, inactive, archived

**Relationships**:
- BelongsToMany: SafariPackage (via package_destination)

### 3.11 PackageDestination Pivot Table
**Purpose**: Many-to-many relationship between packages and destinations

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| package_id | BIGINT UNSIGNED | FK, PK | Package ID |
| destination_id | BIGINT UNSIGNED | FK, PK | Destination ID |

### 3.12 PackageGallery Table
**Purpose**: Store package gallery images

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| id | BIGINT UNSIGNED | PK, AI | Unique identifier |
| package_id | BIGINT UNSIGNED | FK, NOT NULL | Related package |
| image_path | VARCHAR(255) | NOT NULL | Image path |
| alt_text | VARCHAR(255) | NULLABLE | Alt text |
| display_order | INT | NOT NULL, DEFAULT 0 | Display order |
| created_at | TIMESTAMP | NOT NULL | Record creation time |

**Relationships**:
- BelongsTo: SafariPackage

### 3.13 BlogPosts Table
**Purpose**: Store blog post information

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| id | BIGINT UNSIGNED | PK, AI | Unique identifier |
| category_id | BIGINT UNSIGNED | FK, NULLABLE | Blog category |
| author_id | BIGINT UNSIGNED | FK, NOT NULL | Author user ID |
| title | VARCHAR(255) | NOT NULL, UNIQUE | Post title |
| slug | VARCHAR(255) | NOT NULL, UNIQUE | URL slug |
| featured_image | VARCHAR(255) | NULLABLE | Featured image path |
| content | TEXT | NOT NULL | Post content |
| is_published | BOOLEAN | NOT NULL, DEFAULT FALSE | Published flag |
| allow_comments | BOOLEAN | NOT NULL, DEFAULT TRUE | Comments allowed flag |
| publish_date | TIMESTAMP | NULLABLE | Scheduled publish date |
| meta_title | VARCHAR(255) | NULLABLE | SEO meta title |
| meta_desc | TEXT | NULLABLE | SEO meta description |
| created_at | TIMESTAMP | NOT NULL | Record creation time |
| updated_at | TIMESTAMP | NOT NULL | Record update time |
| deleted_at | TIMESTAMP | NULLABLE | Soft delete timestamp |

**Relationships**:
- BelongsTo: BlogCategory
- BelongsTo: User (as author)
- BelongsToMany: BlogTag (via blog_post_tag)
- HasMany: BlogComments

### 3.14 BlogCategories Table
**Purpose**: Define blog categories

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| id | BIGINT UNSIGNED | PK, AI | Unique identifier |
| name | VARCHAR(255) | NOT NULL, UNIQUE | Category name |
| slug | VARCHAR(255) | NOT NULL, UNIQUE | URL slug |
| description | TEXT | NULLABLE | Category description |
| created_at | TIMESTAMP | NOT NULL | Record creation time |
| updated_at | TIMESTAMP | NOT NULL | Record update time |

**Relationships**:
- HasMany: BlogPosts

### 3.15 BlogTags Table
**Purpose**: Define blog tags

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| id | BIGINT UNSIGNED | PK, AI | Unique identifier |
| name | VARCHAR(255) | NOT NULL, UNIQUE | Tag name |
| slug | VARCHAR(255) | NOT NULL, UNIQUE | URL slug |
| created_at | TIMESTAMP | NOT NULL | Record creation time |
| updated_at | TIMESTAMP | NOT NULL | Record update time |

**Relationships**:
- BelongsToMany: BlogPost (via blog_post_tag)

### 3.16 BlogPostTag Pivot Table
**Purpose**: Many-to-many relationship between posts and tags

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| post_id | BIGINT UNSIGNED | FK, PK | Blog post ID |
| tag_id | BIGINT UNSIGNED | FK, PK | Tag ID |

### 3.17 BlogComments Table
**Purpose**: Store blog post comments

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| id | BIGINT UNSIGNED | PK, AI | Unique identifier |
| post_id | BIGINT UNSIGNED | FK, NOT NULL | Related blog post |
| user_name | VARCHAR(255) | NOT NULL | Commenter name |
| email | VARCHAR(255) | NOT NULL | Commenter email |
| comment | TEXT | NOT NULL | Comment content |
| status | ENUM | NOT NULL, DEFAULT pending | Comment status |
| created_at | TIMESTAMP | NOT NULL | Record creation time |
| updated_at | TIMESTAMP | NOT NULL | Record update time |

**Status Enum Values**: pending, approved, rejected, spam

**Relationships**:
- BelongsTo: BlogPost

### 3.18 Testimonials Table
**Purpose**: Store customer testimonials

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| id | BIGINT UNSIGNED | PK, AI | Unique identifier |
| package_id | BIGINT UNSIGNED | FK, NULLABLE | Related package |
| client_name | VARCHAR(255) | NOT NULL | Client name |
| country | VARCHAR(100) | NOT NULL | Client country |
| photo | VARCHAR(255) | NULLABLE | Client photo path |
| review | TEXT | NOT NULL | Review text |
| rating | INT | NOT NULL, DEFAULT 5 | Rating (1-5) |
| tour_date | DATE | NULLABLE | Date of tour |
| status | ENUM | NOT NULL, DEFAULT pending | Approval status |
| is_featured | BOOLEAN | NOT NULL, DEFAULT FALSE | Featured flag |
| created_at | TIMESTAMP | NOT NULL | Record creation time |
| updated_at | TIMESTAMP | NOT NULL | Record update time |

**Status Enum Values**: pending, approved, rejected

**Relationships**:
- BelongsTo: SafariPackage

### 3.19 HomepageSections Table
**Purpose**: Manage homepage sections (hero, CTAs, etc.)

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| id | BIGINT UNSIGNED | PK, AI | Unique identifier |
| section_type | ENUM | NOT NULL | Section type |
| title | VARCHAR(255) | NULLABLE | Section title |
| subtitle | TEXT | NULLABLE | Section subtitle |
| image_path | VARCHAR(255) | NULLABLE | Background image |
| link_url | VARCHAR(255) | NULLABLE | Link URL |
| link_text | VARCHAR(255) | NULLABLE | Link text |
| content | JSON | NULLABLE | Additional content |
| display_order | INT | NOT NULL, DEFAULT 0 | Display order |
| is_active | BOOLEAN | NOT NULL, DEFAULT TRUE | Active flag |
| created_at | TIMESTAMP | NOT NULL | Record creation time |
| updated_at | TIMESTAMP | NOT NULL | Record update time |

**Section Type Enum Values**: hero, featured_safaris, popular_destinations, testimonials, cta_section

### 3.20 NewsletterSubscribers Table
**Purpose**: Store newsletter subscribers

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| id | BIGINT UNSIGNED | PK, AI | Unique identifier |
| email | VARCHAR(255) | UNIQUE, NOT NULL | Subscriber email |
| status | ENUM | NOT NULL, DEFAULT active | Subscription status |
| created_at | TIMESTAMP | NOT NULL | Record creation time |
| updated_at | TIMESTAMP | NOT NULL | Record update time |

**Status Enum Values**: active, unsubscribed, bounced

### 3.21 ActivityLogs Table
**Purpose**: Track user activity for audit purposes

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| id | BIGINT UNSIGNED | PK, AI | Unique identifier |
| user_id | BIGINT UNSIGNED | FK, NULLABLE | User who performed action |
| action | VARCHAR(100) | NOT NULL | Action performed |
| description | TEXT | NULLABLE | Action description |
| ip_address | VARCHAR(45) | NULLABLE | IP address |
| user_agent | TEXT | NULLABLE | User agent string |
| created_at | TIMESTAMP | NOT NULL | Record creation time |

**Relationships**:
- BelongsTo: User

### 3.22 Settings Table
**Purpose**: Store system-wide settings

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| id | BIGINT UNSIGNED | PK, AI | Unique identifier |
| key | VARCHAR(255) | UNIQUE, NOT NULL | Setting key |
| value | TEXT | NULLABLE | Setting value |
| type | VARCHAR(50) | NOT NULL, DEFAULT string | Value type |
| created_at | TIMESTAMP | NOT NULL | Record creation time |
| updated_at | TIMESTAMP | NOT NULL | Record update time |

**Sample Settings**:
- site_name, site_description, contact_email, contact_phone, social_media_links

### 3.23 Laravel System Tables

These are standard Laravel tables used by the framework:

**PasswordResetTokens**:
- email (VARCHAR(255), PRIMARY)
- token (VARCHAR(255))
- created_at (TIMESTAMP)

**PersonalAccessTokens**:
- id (BIGINT UNSIGNED, PK, AI)
- tokenable_type (VARCHAR(255))
- tokenable_id (BIGINT UNSIGNED)
- name (VARCHAR(255))
- token (VARCHAR(64), UNIQUE)
- abilities (TEXT)
- last_used_at (TIMESTAMP)
- expires_at (TIMESTAMP)
- created_at (TIMESTAMP)

**Jobs**:
- id (BIGINT UNSIGNED, PK, AI)
- queue (VARCHAR(255))
- payload (LONGTEXT)
- attempts (UNSIGNED INT)
- reserved_at (UNSIGNED INT)
- available_at (UNSIGNED INT)
- created_at (UNSIGNED INT)

**FailedJobs**:
- id (BIGINT UNSIGNED, PK, AI)
- uuid (VARCHAR(255), UNIQUE)
- connection (TEXT)
- queue (TEXT)
- payload (LONGTEXT)
- exception (LONGTEXT)
- failed_at (TIMESTAMP)

**Migrations**:
- id (INT, PK, AI)
- migration (VARCHAR(255))
- batch (INT)

**Sessions**:
- id (VARCHAR(255), PRIMARY)
- user_id (BIGINT UNSIGNED, NULLABLE)
- ip_address (VARCHAR(45), NULLABLE)
- user_agent (TEXT, NULLABLE)
- payload (LONGTEXT, NOT NULL)
- last_activity (INT, NOT NULL)

## 4. Relationships Summary

### 4.1 User Relationships
- User hasMany Enquiries (as customer)
- User hasMany Enquiries (as assigned_to - Sales Agent)
- User hasMany EnquiryNotes
- User hasMany ActivityLogs
- User hasMany BlogPosts (as author)
- User belongsToMany Roles
- User belongsToMany Permissions

### 4.2 Enquiry Relationships
- Enquiry belongsTo User (customer)
- Enquiry belongsTo User (assigned_to - Sales Agent)
- Enquiry belongsTo SafariPackage
- Enquiry hasMany EnquiryNotes
- Enquiry hasMany EnquiryStatusHistory
- Enquiry hasMany FollowUpReminders

### 4.3 SafariPackage Relationships
- SafariPackage belongsTo PackageCategory
- SafariPackage belongsToMany Destination
- SafariPackage hasMany PackageGallery
- SafariPackage hasMany Enquiries
- SafariPackage hasMany Testimonials

### 4.4 Destination Relationships
- Destination belongsToMany SafariPackage

### 4.5 BlogPost Relationships
- BlogPost belongsTo BlogCategory
- BlogPost belongsTo User (author)
- BlogPost belongsToMany BlogTag
- BlogPost hasMany BlogComments

### 4.6 Testimonial Relationships
- Testimonial belongsTo SafariPackage

## 5. Indexes and Constraints

### 5.1 Primary Keys
All tables use auto-incrementing BIGINT UNSIGNED primary keys named `id`.

### 5.2 Unique Indexes
- users.email
- roles.name
- permissions.name
- safari_packages.title
- safari_packages.slug
- destinations.name
- destinations.slug
- blog_posts.title
- blog_posts.slug
- newsletter_subscribers.email
- settings.key

### 5.3 Foreign Key Constraints
All foreign key constraints have ON DELETE CASCADE or ON DELETE SET NULL as appropriate.

### 5.4 Composite Indexes
- package_destination (package_id, destination_id)
- blog_post_tag (post_id, tag_id)
- enquiries (status, created_at)
- enquiries (assigned_to, status)

### 5.5 Performance Indexes
- enquiries.created_at (for date filtering)
- enquiries.status (for status filtering)
- safari_packages.is_published (for published queries)
- safari_packages.is_featured (for featured queries)
- blog_posts.is_published (for published queries)
- blog_posts.publish_date (for scheduled posts)
- activity_logs.created_at (for log queries)

## 6. Data Integrity Rules

### 6.1 Validation Rules
- Email fields must be valid email format
- Phone numbers must match international format
- Status fields must use predefined enum values
- Rating fields must be between 1-5
- Price fields must be positive numbers
- Dates must be valid date format

### 6.2 Business Rules
- A user cannot be assigned to their own enquiry
- Published packages must have all required fields
- Testimonials must be approved before display
- Enquiries cannot be deleted if confirmed
- Soft delete used for major entities (users, packages, blog posts)

## 7. Database Performance Considerations

### 7.1 Query Optimization
- Use eager loading to prevent N+1 queries
- Implement database indexing on frequently queried columns
- Use query caching for read-heavy operations
- Implement pagination for large datasets

### 7.2 Scalability Considerations
- Consider partitioning for large tables (enquiries, activity_logs)
- Implement read replicas for read-heavy operations
- Use connection pooling
- Consider implementing database sharding for extreme scale

## 8. Backup and Recovery Strategy

### 8.1 Backup Strategy
- Daily automated backups
- Weekly full backups
- Monthly archive backups
- Real-time replication for critical data

### 8.2 Recovery Strategy
- Point-in-time recovery capability
- Backup validation and testing
- Documented recovery procedures
- Offsite backup storage

This ERD provides a complete foundation for the Safari Tour Management System database structure, supporting all functional requirements while maintaining data integrity and performance optimization.
