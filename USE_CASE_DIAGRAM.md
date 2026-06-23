# Safari Tour Management System - Use Case Diagram Documentation

## 1. System Overview

The Safari Tour Management System is designed with multiple user roles interacting with different system modules. This document describes all use cases for each actor in the system.

## 2. Actors

### 2.1 Primary Actors

#### 2.1.1 Super Admin
- **Description**: Highest-level administrator with full system access
- **Responsibilities**: System configuration, user management, oversight of all operations

#### 2.1.2 Admin
- **Description**: Administrative user with management capabilities
- **Responsibilities**: Content management, enquiry supervision, user management

#### 2.1.3 Content Manager
- **Description**: User responsible for website content
- **Responsibilities**: Package management, blog posts, destinations, testimonials

#### 2.1.4 Sales Agent
- **Description**: Sales team member handling customer enquiries
- **Responsibilities**: Enquiry management, customer communication, quotations

#### 2.1.5 Customer
- **Description**: Website visitor or registered customer
- **Responsibilities**: Browse content, submit enquiries, manage profile

### 2.2 Secondary Actors

#### 2.2.1 Email System
- **Description**: External email service for notifications
- **Responsibilities**: Sending confirmation emails, notifications, password resets

#### 2.2.2 File Storage System
- **Description**: Storage service for images and documents
- **Responsibilities**: Storing and retrieving uploaded files

## 3. Use Case Diagrams by Module

### 3.1 User Management Module Use Cases

```
┌─────────────────────────────────────────────────────────────────┐
│                    USER MANAGEMENT MODULE                       │
├─────────────────────────────────────────────────────────────────┤
│                                                                 │
│  ┌──────────────┐     ┌──────────────┐     ┌──────────────┐   │
│  │  Super Admin │     │    Admin     │     │   Customer   │   │
│  └──────┬───────┘     └──────┬───────┘     └──────┬───────┘   │
│         │                    │                     │           │
│         │                    │                     │           │
│  ┌──────▼────────────────────▼─────────────────────▼──────┐    │
│  │                    SYSTEM BOUNDARY                      │
│  │                                                          │
│  │  ┌──────────────────────────────────────────────────┐   │
│  │  │            AUTHENTICATION USE CASES              │   │
│  │  │                                                  │   │
│  │  │  • Register (Customer)                          │   │
│  │  │  • Login (All Actors)                           │   │
│  │  │  • Logout (All Actors)                          │   │
│  │  │  • Forgot Password (All Actors)                 │   │
│  │  │  • Reset Password (All Actors)                  │   │
│  │  │  • Update Profile (All Actors)                  │   │
│  │  │  • Change Password (All Actors)                 │   │
│  │  │  • Enable 2FA (All Actors - Optional)           │   │
│  │  └──────────────────────────────────────────────────┘   │
│  │                                                          │
│  │  ┌──────────────────────────────────────────────────┐   │
│  │  │            USER MANAGEMENT USE CASES              │   │
│  │  │                                                  │   │
│  │  │  • Create User (Super Admin, Admin)             │   │
│  │  │  • View User List (Super Admin, Admin)          │   │
│  │  │  • View User Details (Super Admin, Admin)       │   │
│  │  │  • Update User (Super Admin, Admin)              │   │
│  │  │  • Delete User (Super Admin)                     │   │
│  │  │  • Activate User (Super Admin, Admin)            │   │
│  │  │  • Deactivate User (Super Admin, Admin)          │   │
│  │  │  • Assign Role (Super Admin, Admin)              │   │
│  │  │  • Assign Permissions (Super Admin)              │   │
│  │  │  • View Activity Logs (Super Admin, Admin)       │   │
│  │  │  • Export User Data (Super Admin, Admin)         │   │
│  │  └──────────────────────────────────────────────────┘   │
│  │                                                          │
│  └──────────────────────────────────────────────────────────┘
│                                                                 │
└─────────────────────────────────────────────────────────────────┘
```

### 3.2 Enquiry Management Module Use Cases

```
┌─────────────────────────────────────────────────────────────────┐
│                  ENQUIRY MANAGEMENT MODULE                      │
├─────────────────────────────────────────────────────────────────┤
│                                                                 │
│  ┌──────────────┐     ┌──────────────┐     ┌──────────────┐   │
│  │  Super Admin │     │    Admin     │     │ Sales Agent  │   │
│  └──────┬───────┘     └──────┬───────┘     └──────┬───────┘   │
│         │                    │                     │           │
│  ┌──────▼────────────────────▼─────────────────────▼──────┐    │
│  │                    SYSTEM BOUNDARY                      │
│  │                                                          │
│  │  ┌──────────────────────────────────────────────────┐   │
│  │  │            PUBLIC ENQUIRY USE CASES              │   │
│  │  │                                                  │   │
│  │  │  • Submit Enquiry (Guest, Customer)             │   │
│  │  │  • View Enquiry Status (Customer)                │   │
│  │  │  • Update Enquiry (Customer - limited)           │   │
│  │  └──────────────────────────────────────────────────┘   │
│  │                                                          │
│  │  ┌──────────────────────────────────────────────────┐   │
│  │  │          ENQUIRY MANAGEMENT USE CASES            │   │
│  │  │                                                  │   │
│  │  │  • View All Enquiries (Super Admin, Admin)       │   │
│  │  │  • View Assigned Enquiries (Sales Agent)         │   │
│  │  │  • View Enquiry Details (Super Admin, Admin,     │   │
│  │  │                      Sales Agent)                 │   │
│  │  │  • Update Enquiry (Super Admin, Admin,           │   │
│  │  │                   Sales Agent)                   │   │
│  │  │  • Update Enquiry Status (Super Admin, Admin,    │   │
│  │  │                         Sales Agent)             │   │
│  │  │  • Assign Enquiry (Super Admin, Admin)           │   │
│  │  │  • Reassign Enquiry (Super Admin, Admin)         │   │
│  │  │  • Add Internal Note (Super Admin, Admin,       │   │
│  │  │                      Sales Agent)                 │   │
│  │  │  • Set Follow-up Reminder (Super Admin, Admin,   │   │
│  │  │                           Sales Agent)            │   │
│  │  │  • View Enquiry History (Super Admin, Admin,     │   │
│  │  │                         Sales Agent)             │   │
│  │  │  • Delete Enquiry (Super Admin, Admin)          │   │
│  │  │  • Search Enquiries (Super Admin, Admin,         │   │
│  │  │                    Sales Agent)                  │   │
│  │  │  • Filter Enquiries (Super Admin, Admin,         │   │
│  │  │                    Sales Agent)                  │   │
│  │  │  • Export Enquiries to Excel (Super Admin,      │   │
│  │  │                           Admin)                 │   │
│  │  │  • Export Enquiries to PDF (Super Admin, Admin) │   │
│  │  │  • Send Quotation Email (Sales Agent)            │   │
│  │  │  • Send Follow-up Email (Sales Agent)            │   │
│  │  └──────────────────────────────────────────────────┘   │
│  │                                                          │
│  └──────────────────────────────────────────────────────────┘
│                                                                 │
└─────────────────────────────────────────────────────────────────┘
```

### 3.3 Content Management Module Use Cases

```
┌─────────────────────────────────────────────────────────────────┐
│                  CONTENT MANAGEMENT MODULE                      │
├─────────────────────────────────────────────────────────────────┤
│                                                                 │
│  ┌──────────────┐     ┌──────────────┐     ┌──────────────┐   │
│  │ Content Mgr  │     │    Admin     │     │  Super Admin │   │
│  └──────┬───────┘     └──────┬───────┘     └──────┬───────┘   │
│         │                    │                     │           │
│  ┌──────▼────────────────────▼─────────────────────▼──────┐    │
│  │                    SYSTEM BOUNDARY                      │
│  │                                                          │
│  │  ┌──────────────────────────────────────────────────┐   │
│  │  │           SAFARI PACKAGES USE CASES               │   │
│  │  │                                                  │   │
│  │  │  • Create Package (Content Manager, Admin)       │   │
│  │  │  • View Package List (Content Manager, Admin)     │   │
│  │  │  • View Package Details (Content Manager, Admin)  │   │
│  │  │  • Update Package (Content Manager, Admin)       │   │
│  │  │  • Delete Package (Content Manager, Admin)       │   │
│  │  │  • Publish Package (Content Manager, Admin)       │   │
│  │  │  • Unpublish Package (Content Manager, Admin)     │   │
│  │  │  • Feature Package (Content Manager, Admin)       │   │
│  │  │  • Duplicate Package (Content Manager, Admin)     │   │
│  │  │  • Upload Package Images (Content Manager,       │   │
│  │  │                      Admin)                       │   │
│  │  │  • Manage Package Gallery (Content Manager,      │   │
│  │  │                         Admin)                    │   │
│  │  │  • View Package Analytics (Content Manager,      │   │
│  │  │                            Admin)                 │   │
│  │  └──────────────────────────────────────────────────┘   │
│  │                                                          │
│  │  ┌──────────────────────────────────────────────────┐   │
│  │  │            DESTINATIONS USE CASES                 │   │
│  │  │                                                  │   │
│  │  │  • Create Destination (Content Manager, Admin)    │   │
│  │  │  • View Destination List (Content Manager,       │   │
│  │  │                         Admin)                    │   │
│  │  │  • View Destination Details (Content Manager,     │   │
│  │  │                              Admin)               │   │
│  │  │  • Update Destination (Content Manager, Admin)    │   │
│  │  │  • Delete Destination (Content Manager, Admin)   │   │
│  │  │  • Feature Destination (Content Manager, Admin)  │   │
│  │  │  • Upload Destination Images (Content Manager,   │   │
│  │  │                             Admin)                │   │
│  │  │  • Associate Packages (Content Manager, Admin)   │   │
│  │  └──────────────────────────────────────────────────┘   │
│  │                                                          │
│  │  ┌──────────────────────────────────────────────────┐   │
│  │  │               BLOG USE CASES                     │   │
│  │  │                                                  │   │
│  │  │  • Create Blog Post (Content Manager, Admin)     │   │
│  │  │  • View Blog Post List (Content Manager, Admin)  │   │
│  │  │  • View Blog Post Details (Content Manager,     │   │
│  │  │                           Admin)                  │   │
│  │  │  • Update Blog Post (Content Manager, Admin)      │   │
│  │  │  • Delete Blog Post (Content Manager, Admin)     │   │
│  │  │  • Publish Blog Post (Content Manager, Admin)    │   │
│  │  │  • Schedule Blog Post (Content Manager, Admin)   │   │
│  │  │  • Manage Categories (Content Manager, Admin)     │   │
│  │  │  • Manage Tags (Content Manager, Admin)           │   │
│  │  │  • Moderate Comments (Content Manager, Admin)    │   │
│  │  │  • Upload Blog Images (Content Manager, Admin)    │   │
│  │  └──────────────────────────────────────────────────┘   │
│  │                                                          │
│  │  ┌──────────────────────────────────────────────────┐   │
│  │  │            TESTIMONIALS USE CASES                │   │
│  │  │                                                  │   │
│  │  │  • Create Testimonial (Content Manager, Admin)   │   │
│  │  │  • View Testimonial List (Content Manager,      │   │
│  │  │                          Admin)                   │   │
│  │  │  • Approve Testimonial (Content Manager, Admin)  │   │
│  │  │  • Reject Testimonial (Content Manager, Admin)    │   │
│  │  │  • Update Testimonial (Content Manager, Admin)    │   │
│  │  │  • Delete Testimonial (Content Manager, Admin)   │   │
│  │  │  • Feature Testimonial (Content Manager, Admin)  │   │
│  │  │  • Upload Testimonial Photo (Content Manager,    │   │
│  │  │                             Admin)                 │   │
│  │  └──────────────────────────────────────────────────┘   │
│  │                                                          │
│  │  ┌──────────────────────────────────────────────────┐   │
│  │  │            HOMEPAGE USE CASES                    │   │
│  │  │                                                  │   │
│  │  │  • Manage Hero Banners (Content Manager, Admin)   │   │
│  │  │  • Manage Featured Safaris (Content Manager,     │   │
│  │  │                            Admin)                 │   │
│  │  │  • Manage Popular Destinations (Content Manager,│   │
│  │  │                                Admin)             │   │
│  │  │  • Manage Testimonials (Content Manager, Admin)  │   │
│  │  │  • Manage CTA Sections (Content Manager, Admin) │   │
│  │  │  • Update Homepage Layout (Content Manager,     │   │
│  │  │                          Admin)                   │   │
│  │  └──────────────────────────────────────────────────┘   │
│  │                                                          │
│  └──────────────────────────────────────────────────────────┘
│                                                                 │
└─────────────────────────────────────────────────────────────────┘
```

### 3.4 Public Website Use Cases

```
┌─────────────────────────────────────────────────────────────────┐
│                      PUBLIC WEBSITE MODULE                       │
├─────────────────────────────────────────────────────────────────┤
│                                                                 │
│  ┌──────────────┐     ┌──────────────┐                         │
│  │    Guest     │     │   Customer   │                         │
│  └──────┬───────┘     └──────┬───────┘                         │
│         │                    │                                   │
│  ┌──────▼────────────────────▼──────┐                            │
│  │          SYSTEM BOUNDARY         │                            │
│  │                                   │                            │
│  │  ┌─────────────────────────────┐  │                            │
│  │  │      BROWSING USE CASES     │  │                            │
│  │  │                             │  │                            │
│  │  │  • View Home Page           │  │                            │
│  │  │  • View About Us Page       │  │                            │
│  │  │  • View Safari Packages     │  │                            │
│  │  │  • View Package Details     │  │                            │
│  │  │  • View Destinations        │  │                            │
│  │  │  • View Destination Details │  │                            │
│  │  │  • View Blog                │  │                            │
│  │  │  • View Blog Post           │  │                            │
│  │  │  • View Testimonials        │  │                            │
│  │  │  • View Contact Page        │  │                            │
│  │  │  • View Enquiry Form        │  │                            │
│  │  └─────────────────────────────┘  │                            │
│  │                                   │                            │
│  │  ┌─────────────────────────────┐  │                            │
│  │  │      SEARCH & FILTER        │  │                            │
│  │  │                             │  │                            │
│  │  │  • Search Safaris           │  │                            │
│  │  │  • Filter by Destination    │  │                            │
│  │  │  • Filter by Duration       │  │                            │
│  │  │  • Filter by Price          │  │                            │
│  │  │  • Filter by Category       │  │                            │
│  │  │  • Sort Results             │  │                            │
│  │  └─────────────────────────────┘  │                            │
│  │                                   │                            │
│  │  ┌─────────────────────────────┐  │                            │
│  │  │      INTERACTION USE CASES  │  │                            │
│  │  │                             │  │                            │
│  │  │  • Submit Enquiry           │  │                            │
│  │  │  • Subscribe Newsletter     │  │                            │
│  │  │  • Share Content            │  │                            │
│  │  │  • Add Blog Comment         │  │                            │
│  │  │  • Contact Support          │  │                            │
│  │  └─────────────────────────────┘  │                            │
│  │                                   │                            │
│  │  ┌─────────────────────────────┐  │                            │
│  │  │      ACCOUNT USE CASES     │  │                            │
│  │  │                             │  │                            │
│  │  │  • Register                 │  │                            │
│  │  │  • Login                    │  │                            │
│  │  │  • Update Profile           │  │                            │
│  │  │  • View Enquiry History     │  │                            │
│  │  │  • Logout                   │  │                            │
│  │  └─────────────────────────────┘  │                            │
│  │                                   │                            │
│  └───────────────────────────────────┘                            │
│                                                                 │
└─────────────────────────────────────────────────────────────────┘
```

### 3.5 Dashboard Use Cases

```
┌─────────────────────────────────────────────────────────────────┐
│                       DASHBOARD MODULE                           │
├─────────────────────────────────────────────────────────────────┤
│                                                                 │
│  ┌──────────────┐     ┌──────────────┐     ┌──────────────┐   │
│  │  Super Admin │     │    Admin     │     │ Sales Agent  │   │
│  └──────┬───────┘     └──────┬───────┘     └──────┬───────┘   │
│         │                    │                     │           │
│  ┌──────▼────────────────────▼─────────────────────▼──────┐    │
│  │                    SYSTEM BOUNDARY                      │
│  │                                                          │
│  │  ┌──────────────────────────────────────────────────┐   │
│  │  │           ADMIN DASHBOARD USE CASES                │   │
│  │  │                                                  │   │
│  │  │  • View Dashboard Statistics                     │   │
│  │  │  • View User Statistics                          │   │
│  │  │  • View Enquiry Statistics                       │   │
│  │  │  • View Revenue Statistics                       │   │
│  │  │  • View Charts and Graphs                        │   │
│  │  │  • View Recent Activities                        │   │
│  │  │  • View System Notifications                      │   │
│  │  │  • Generate Reports                              │   │
│  │  │  • Export Reports                                │   │
│  │  │  • View System Health                             │   │
│  │  └──────────────────────────────────────────────────┘   │
│  │                                                          │
│  │  ┌──────────────────────────────────────────────────┐   │
│  │  │          SALES DASHBOARD USE CASES               │   │
│  │  │                                                  │   │
│  │  │  • View Assigned Enquiries                       │   │
│  │  │  • View Follow-ups Due                           │   │
│  │  │  • View Conversion Rate                          │   │
│  │  │  • View Total Confirmations                       │   │
│  │  │  • View Performance Metrics                       │   │
│  │  │  • View Recent Communications                      │   │
│  │  │  • View Enquiry Status Distribution               │   │
│  │  │  • View Follow-up Schedule                        │   │
│  │  └──────────────────────────────────────────────────┘   │
│  │                                                          │
│  └──────────────────────────────────────────────────────────┘
│                                                                 │
└─────────────────────────────────────────────────────────────────┘
```

## 4. Detailed Use Case Descriptions

### 4.1 Authentication Use Cases

#### UC-001: Register
- **Actor**: Guest/Customer
- **Description**: New user creates an account
- **Preconditions**: User has valid email
- **Flow**:
  1. User navigates to registration page
  2. User enters registration details
  3. System validates input
  4. System creates user account
  5. System sends verification email
  6. User verifies email
- **Postconditions**: User account created and verified

#### UC-002: Login
- **Actor**: All authenticated users
- **Description**: User authenticates to access system
- **Preconditions**: User has valid credentials
- **Flow**:
  1. User navigates to login page
  2. User enters email and password
  3. System validates credentials
  4. System creates session
  5. User redirected to appropriate dashboard
- **Postconditions**: User authenticated and logged in

#### UC-003: Forgot Password
- **Actor**: All authenticated users
- **Description**: User requests password reset
- **Preconditions**: User has valid email
- **Flow**:
  1. User requests password reset
  2. User enters email address
  3. System validates email exists
  4. System sends reset link
  5. User clicks reset link
  6. User sets new password
- **Postconditions**: Password updated successfully

### 4.2 Enquiry Management Use Cases

#### UC-010: Submit Enquiry
- **Actor**: Guest/Customer
- **Description**: User submits safari enquiry
- **Preconditions**: None
- **Flow**:
  1. User navigates to enquiry form
  2. User fills required fields
  3. User submits form
  4. System validates data
  5. System stores enquiry
  6. System sends confirmation email
  7. System notifies sales team
- **Postconditions**: Enquiry created in system

#### UC-011: Assign Enquiry
- **Actor**: Super Admin, Admin
- **Description**: Administrator assigns enquiry to sales agent
- **Preconditions**: Enquiry exists, sales agent exists
- **Flow**:
  1. Admin views enquiry
  2. Admin selects sales agent
  3. System assigns enquiry
  4. System notifies sales agent
- **Postconditions**: Enquiry assigned to agent

#### UC-012: Update Enquiry Status
- **Actor**: Super Admin, Admin, Sales Agent
- **Description**: User updates enquiry status
- **Preconditions**: Enquiry exists
- **Flow**:
  1. User views enquiry details
  2. User selects new status
  3. User adds optional notes
  4. System updates status
  5. System records status change
  6. System sends notification (if required)
- **Postconditions**: Enquiry status updated

### 4.3 Content Management Use Cases

#### UC-020: Create Package
- **Actor**: Content Manager, Admin
- **Description**: User creates new safari package
- **Preconditions**: User has content management permissions
- **Flow**:
  1. User navigates to create package page
  2. User enters package details
  3. User uploads images
  4. User saves package
  5. System validates data
  6. System creates package
  7. System generates slug
  8. System stores images
- **Postconditions**: Package created successfully

#### UC-021: Publish Package
- **Actor**: Content Manager, Admin
- **Description**: User publishes package to website
- **Preconditions**: Package exists in draft status
- **Flow**:
  1. User views package
  2. User clicks publish
  3. System updates status to published
  4. Package becomes visible on website
- **Postconditions**: Package published

#### UC-022: Create Blog Post
- **Actor**: Content Manager, Admin
- **Description**: User creates new blog post
- **Preconditions**: User has blog management permissions
- **Flow**:
  1. User navigates to create blog post
  2. User enters blog content
  3. User selects category and tags
  4. User uploads featured image
  5. User saves post
  6. System creates blog post
  7. System generates slug
- **Postconditions**: Blog post created

### 4.4 Dashboard Use Cases

#### UC-030: View Dashboard Statistics
- **Actor**: Super Admin, Admin, Sales Agent
- **Description**: User views dashboard statistics
- **Preconditions**: User authenticated
- **Flow**:
  1. User navigates to dashboard
  2. System retrieves relevant statistics
  3. System displays statistics cards
  4. System displays charts and graphs
- **Postconditions**: Dashboard statistics displayed

#### UC-031: Generate Reports
- **Actor**: Super Admin, Admin
- **Description**: User generates system reports
- **Preconditions**: User has report generation permissions
- **Flow**:
  1. User navigates to reports section
  2. User selects report type
  3. User selects date range
  4. User selects filters
  5. System generates report
  6. System displays report
  7. User can export report
- **Postconditions**: Report generated successfully

## 5. Use Case Relationships

### 5.1 Include Relationships
- **Login** includes **Validate Credentials**
- **Register** includes **Send Verification Email**
- **Submit Enquiry** includes **Validate Input**
- **Create Package** includes **Upload Images**
- **Generate Reports** includes **Apply Filters**

### 5.2 Extend Relationships
- **Login** extended by **Forgot Password**
- **View Package Details** extended by **Book Package** (future)
- **Submit Enquiry** extended by **Upload Documents** (future)
- **Update Enquiry Status** extended by **Send Quotation**

### 5.3 Generalization Relationships
- **User** is generalized by **Super Admin**, **Admin**, **Content Manager**, **Sales Agent**, **Customer**
- **Content Management** is generalized by **Package Management**, **Blog Management**, **Destination Management**, **Testimonial Management**

## 6. Business Rules

### 6.1 User Management Rules
- Super Admin can assign any role
- Admin cannot assign Super Admin role
- Content Manager cannot delete published content without permission
- Sales agents can only view their assigned enquiries
- Customers can only view their own enquiries

### 6.2 Enquiry Management Rules
- Enquiries must be assigned within 24 hours
- Status changes must be logged
- Follow-up reminders must be set for each status change
- Enquiries cannot be deleted if confirmed
- Only sales agents can update their assigned enquiries

### 6.3 Content Management Rules
- Published content cannot be deleted (only archived)
- At least one featured package must exist
- Blog posts must belong to a category
- Testimonials must be approved before display
- Published content must have all required fields

## 7. System Boundaries

### 7.1 In Scope
- User authentication and authorization
- Enquiry management system
- Content management system
- Public website
- Admin dashboard
- Sales dashboard
- Email notifications
- File management
- Reporting system

### 7.2 Out of Scope
- Payment processing (Phase 2)
- Mobile app (Phase 2)
- Social media integration (Phase 2)
- Multi-language support (Phase 2)
- Travel insurance (Phase 3)
- Visa processing (Phase 3)

## 8. Assumptions and Dependencies

### 8.1 Assumptions
- Users have basic computer literacy
- Email service is reliable
- File storage has sufficient capacity
- Database can handle expected load
- Internet connection is stable

### 8.2 Dependencies
- Email service provider (SMTP/SendGrid/Mailgun)
- File storage service (Local/S3)
- Database server (MySQL)
- Web server (Apache/Nginx)
- PHP runtime environment
