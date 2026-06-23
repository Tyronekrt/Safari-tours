# Safari Tour Management System - Software Requirements Specification

## 1. Introduction

### 1.1 Purpose
This document outlines the comprehensive requirements for the Safari Tour Management System, a web-based application designed to manage safari tour operations, customer enquiries, content management, and user administration.

### 1.2 Scope
The system will provide:
- User management with role-based access control
- Enquiry management system for customer interactions
- Content management system for safari packages, destinations, blogs, and testimonials
- Public-facing website with responsive design
- Admin dashboard for system management
- RESTful API for mobile app integration

### 1.3 Intended Audience
- Software Developers
- System Architects
- Database Administrators
- Project Stakeholders
- Quality Assurance Team

## 2. System Overview

### 2.1 Technology Stack
- **Backend Framework**: Laravel 12
- **PHP Version**: PHP 8.3+
- **Database**: MySQL 8.0+
- **Frontend Framework**: Bootstrap 5 / Tailwind CSS
- **Authentication**: Laravel Breeze
- **Authorization**: Spatie Laravel Permission
- **Architecture**: RESTful API with MVC pattern
- **Design**: Mobile-first responsive design

### 2.2 System Modules
1. User Management Module
2. Enquiry Management Module
3. Content Management Module

## 3. Functional Requirements

### 3.1 User Management Module

#### 3.1.1 User Roles
- **Super Admin**: Full system access, user management, system configuration
- **Admin**: Content and enquiry management, user supervision
- **Content Manager**: CMS access, package and destination management
- **Sales Agent**: Enquiry management, customer communication
- **Customer**: Public website access, enquiry submission, profile management

#### 3.1.2 Authentication Features
- User registration with email verification
- Login/logout functionality
- Password reset via email
- Remember me functionality
- Two-factor authentication (optional)
- Session management

#### 3.1.3 User Management Features
- Create, read, update, delete users
- User activation/deactivation
- Role assignment and modification
- Permission management
- Profile management
- User activity logging
- Bulk user operations

#### 3.1.4 Dashboard Features
- Role-based dashboard views
- Statistics overview
- Recent activities
- Quick actions
- System notifications

### 3.2 Enquiry Management Module

#### 3.2.1 Enquiry Form Fields
- Full Name (required)
- Email Address (required, validated)
- Phone Number (required)
- Country (required)
- Safari Package (dropdown)
- Number of Adults (numeric, min 1)
- Number of Children (numeric, min 0)
- Travel Date (date picker)
- Duration (numeric, days)
- Budget Range (dropdown/slider)
- Message (textarea)

#### 3.2.2 Enquiry Status Workflow
- **New**: Initial submission
- **Contacted**: Agent has made contact
- **Quotation Sent**: Price quotation sent to customer
- **Negotiation**: Price/term discussions ongoing
- **Confirmed**: Booking confirmed
- **Cancelled**: Enquiry cancelled by customer or system

#### 3.2.3 Enquiry Management Features
- Enquiry creation and storage
- Enquiry assignment to sales agents
- Status tracking and updates
- Internal notes and comments
- Follow-up reminders with notifications
- Enquiry history and timeline
- Advanced search and filtering
- Export to Excel (XLSX)
- Export to PDF
- Email notifications for status changes
- Bulk operations (assign, update status)
- Enquiry analytics and reporting

#### 3.2.4 Search and Filter Capabilities
- Filter by status
- Filter by assigned agent
- Filter by date range
- Filter by safari package
- Filter by budget range
- Search by name, email, phone
- Filter by country
- Filter by travel date

### 3.3 Content Management Module

#### 3.3.1 Safari Packages Management

**Package Fields:**
- Title (required, unique)
- Slug (auto-generated, editable)
- Featured Image (upload, required)
- Gallery Images (multiple uploads)
- Short Description (required, max 300 chars)
- Full Description (rich text editor)
- Duration (numeric, days)
- Price (numeric, currency)
- Location (text or dropdown)
- Category (dropdown: Budget, Mid-Range, Luxury)
- Highlights (array/list)
- Inclusions (list)
- Exclusions (list)
- Itinerary (day-by-day details)
- SEO Meta Title
- SEO Meta Description
- Status (Draft, Published, Archived)

**Package Features:**
- Create, read, update, delete packages
- Publish/unpublish packages
- Mark as featured
- Bulk operations
- Package duplication
- Package versioning
- Related packages
- Package analytics (views, enquiries)

#### 3.3.2 Destination Management

**Destination Fields:**
- Name (required, unique)
- Slug (auto-generated)
- Description (rich text)
- Featured Image
- Gallery Images
- Country
- Region
- Coordinates (lat/long)
- Best Time to Visit
- Wildlife Highlights
- Activities Available
- SEO Fields (title, description, keywords)
- Status

**Destination Features:**
- CRUD operations
- Image management
- Package association
- Featured destinations
- Destination categories

#### 3.3.3 Blog Management

**Blog Post Fields:**
- Title (required, unique)
- Slug (auto-generated)
- Featured Image
- Content (rich text editor)
- Category
- Tags (multiple)
- Author (user reference)
- Publish Date (scheduling)
- Status (Draft, Published, Archived)
- SEO Fields
- Allow Comments (boolean)

**Blog Features:**
- CRUD operations
- Rich text editing
- Image upload
- Category management
- Tag management
- Post scheduling
- Comment moderation
- Blog analytics
- Related posts

#### 3.3.4 Testimonials Management

**Testimonial Fields:**
- Client Name (required)
- Country (required)
- Photo (upload)
- Review/Review Text (required)
- Rating (1-5 stars)
- Tour Package (reference)
- Date of Tour
- Status (Pending, Approved, Rejected)
- Featured (boolean)

**Testimonial Features:**
- CRUD operations
- Approval workflow
- Featured testimonials
- Rating aggregation
- Photo management

#### 3.3.5 Homepage Management

**Hero Banners:**
- Multiple banner slides
- Background images
- Headline text
- Subheadline
- Call-to-action buttons
- Banner order/priority

**Featured Safaris:**
- Select packages to feature
- Display order
- Expiry dates

**Popular Destinations:**
- Select destinations
- Display order
- Custom labels

**Testimonials:**
- Select testimonials
- Display order

**Call-to-Action Sections:**
- Multiple CTA sections
- Background images
- Headline
- Button text and link
- Position on page

## 4. Frontend Website Requirements

### 4.1 Public Pages

#### 4.1.1 Home Page
- Hero slider with stunning safari imagery
- Featured safari packages carousel
- Popular destinations grid
- Testimonials slider
- Call-to-action sections
- Newsletter subscription form
- Quick enquiry form
- Footer with contact info and links

#### 4.1.2 About Us Page
- Company story and mission
- Team profiles
- Company values
- Certifications and awards
- Photo gallery
- Statistics counter

#### 4.1.3 Safari Packages Page
- Package grid/list view
- Search functionality
- Filters (destination, duration, price, category)
- Sort options (price, duration, popularity)
- Package cards with key info
- Pagination
- Featured packages highlighting

#### 4.1.4 Package Details Page
- Large hero image
- Package title and price
- Quick info bar (duration, location, difficulty)
- Full description
- Highlights section
- Inclusions/Exclusions
- Day-by-day itinerary
- Image gallery
- Package map
- Related packages
- Enquiry form
- Share functionality
- Reviews and ratings

#### 4.1.5 Destinations Page
- Destination grid with cards
- Search and filters
- Featured destinations
- Destination statistics
- Interactive map (optional)

#### 4.1.6 Destination Details Page
- Destination hero section
- Description and overview
- Best time to visit
- Wildlife highlights
- Available activities
- Packages in this destination
- Image gallery
- Travel tips
- Enquiry form

#### 4.1.7 Blog Page
- Blog post grid/list
- Category filters
- Tag filters
- Search functionality
- Featured posts
- Sidebar (categories, popular posts, newsletter)
- Pagination

#### 4.1.8 Blog Details Page
- Post content with formatting
- Author info
- Publish date
- Categories and tags
- Featured image
- Related posts
- Comment section (if enabled)
- Share buttons
- Newsletter signup

#### 4.1.9 Contact Us Page
- Contact information
- Contact form (name, email, subject, message)
- Google Maps integration
- Office hours
- Social media links
- FAQ section

#### 4.1.10 Enquiry Form Page
- Comprehensive enquiry form
- Package pre-selection
- Form validation
- Success confirmation
- Email notification

#### 4.1.11 Testimonials Page
- Testimonials grid
- Filter by rating
- Filter by destination
- Filter by package
- Sort by date
- Overall rating display

### 4.2 Dynamic Features
- Real-time search with autocomplete
- AJAX-based filtering (no page reload)
- Lazy loading for images
- Infinite scroll or pagination
- Cookie consent banner
- Live chat integration (optional)
- Social media sharing
- Print-friendly pages

### 4.3 Newsletter Subscription
- Email input field
- Email validation
- Confirmation email
- Unsubscribe functionality
- Subscriber management in admin

## 5. Dashboard Requirements

### 5.1 Admin Dashboard

**Statistics Cards:**
- Total Users (with growth indicator)
- Total Enquiries (new this month)
- Confirmed Bookings (this month)
- Safari Packages (active count)
- Blog Posts (published)
- Revenue this month

**Charts and Graphs:**
- Enquiry trends (line chart)
- Conversion rates (pie chart)
- Package popularity (bar chart)
- User growth (line chart)
- Revenue by month (area chart)

**Recent Activities:**
- Latest enquiries
- Recent user registrations
- Latest blog posts
- Recent package updates
- System notifications

**Quick Actions:**
- Create new enquiry
- Add new package
- Add new user
- View reports
- System settings

### 5.2 Sales Dashboard

**Statistics Cards:**
- Assigned Enquiries (total)
- Follow-ups Due (today)
- Conversion Rate (percentage)
- Total Confirmations (this month)

**Charts and Graphs:**
- Enquiry status distribution
- Follow-up schedule
- Performance metrics

**Recent Communications:**
- Latest emails sent
- Recent notes added
- Upcoming follow-ups

**Quick Actions:**
- View my enquiries
- Add follow-up
- Send quotation
- Update enquiry status

## 6. Non-Functional Requirements

### 6.1 Performance
- Page load time < 3 seconds
- API response time < 500ms
- Support 1000+ concurrent users
- Database query optimization
- Image optimization and CDN integration

### 6.2 Security
- SQL injection prevention
- XSS protection
- CSRF protection
- Secure password hashing (bcrypt/argon2)
- HTTPS/SSL encryption
- Rate limiting on APIs
- Input validation and sanitization
- File upload security
- Regular security audits

### 6.3 Scalability
- Horizontal scaling capability
- Database replication support
- Caching implementation (Redis)
- Queue system for background jobs
- Load balancing support

### 6.4 Availability
- 99.9% uptime
- Automated backups (daily)
- Disaster recovery plan
- Error logging and monitoring

### 6.5 Usability
- Intuitive user interface
- Consistent design patterns
- Mobile-responsive design
- Accessibility compliance (WCAG 2.1)
- Multi-language support (future)

### 6.6 Maintainability
- Clean code architecture
- Comprehensive documentation
- Unit and integration tests
- Code review process
- Version control (Git)

## 7. Database Requirements

### 7.1 Database Tables
- users
- roles
- permissions
- model_has_permissions
- model_has_roles
- role_has_permissions
- enquiries
- enquiry_notes
- enquiry_status_history
- safari_packages
- package_categories
- destinations
- package_destination (pivot)
- package_gallery
- blog_posts
- blog_categories
- blog_tags
- blog_post_tag (pivot)
- testimonials
- homepage_sections
- newsletters_subscribers
- activity_logs
- settings
- failed_jobs
- jobs
- migrations
- password_reset_tokens
- personal_access_tokens
- sessions

### 7.2 Relationships
- One-to-Many, Many-to-Many relationships as defined in ERD
- Foreign key constraints
- Indexing for performance
- Cascade delete rules

## 8. API Requirements

### 8.1 Authentication API
- POST /api/auth/register
- POST /api/auth/login
- POST /api/auth/logout
- POST /api/auth/forgot-password
- POST /api/auth/reset-password
- GET /api/auth/user

### 8.2 Users API
- GET /api/users
- POST /api/users
- GET /api/users/{id}
- PUT /api/users/{id}
- DELETE /api/users/{id}
- PUT /api/users/{id}/activate
- PUT /api/users/{id}/deactivate
- POST /api/users/{id}/assign-role

### 8.3 Enquiries API
- GET /api/enquiries
- POST /api/enquiries
- GET /api/enquiries/{id}
- PUT /api/enquiries/{id}
- DELETE /api/enquiries/{id}
- PUT /api/enquiries/{id}/assign
- PUT /api/enquiries/{id}/status
- GET /api/enquiries/{id}/history
- POST /api/enquiries/{id}/notes
- GET /api/enquiries/export/excel
- GET /api/enquiries/export/pdf

### 8.4 Safari Packages API
- GET /api/packages
- POST /api/packages
- GET /api/packages/{id}
- PUT /api/packages/{id}
- DELETE /api/packages/{id}
- PUT /api/packages/{id}/publish
- PUT /api/packages/{id}/feature
- GET /api/packages/featured
- GET /api/packages/search

### 8.5 Destinations API
- GET /api/destinations
- POST /api/destinations
- GET /api/destinations/{id}
- PUT /api/destinations/{id}
- DELETE /api/destinations/{id}
- GET /api/destinations/featured
- GET /api/destinations/{id}/packages

### 8.6 Blog Posts API
- GET /api/blog
- POST /api/blog
- GET /api/blog/{id}
- PUT /api/blog/{id}
- DELETE /api/blog/{id}
- PUT /api/blog/{id}/publish
- GET /api/blog/categories
- GET /api/blog/tags

## 9. Integration Requirements

### 9.1 Third-Party Services
- Email service (SMTP, SendGrid, Mailgun)
- File storage (local, S3, CloudFront)
- Payment gateway (optional for future)
- SMS gateway (optional)
- Analytics (Google Analytics)
- Social media sharing APIs

### 9.2 Payment Integration (Future)
- Multiple payment methods
- Secure payment processing
- Invoice generation
- Payment history
- Refund processing

## 10. Reporting Requirements

### 10.1 Reports
- Enquiry reports (daily, weekly, monthly)
- Sales performance reports
- Package popularity reports
- User activity reports
- Conversion rate reports
- Custom date range reports

### 10.2 Export Formats
- Excel (.xlsx)
- PDF
- CSV
- Print-friendly HTML

## 11. System Constraints

### 11.1 Technical Constraints
- Must run on PHP 8.3+
- MySQL 8.0+ required
- Minimum 2GB RAM for development
- SSL certificate required for production

### 11.2 Business Constraints
- Data privacy compliance (GDPR)
- Email marketing compliance
- Customer data protection
- Regular maintenance windows

## 12. Future Enhancements

### 12.1 Phase 2 Features
- Mobile app (iOS/Android)
- Online booking system
- Payment integration
- Multi-language support
- Advanced analytics
- CRM integration
- Live chat support
- Virtual tours
- AI-powered recommendations

### 12.2 Phase 3 Features
- Loyalty program
- Partner management
- Supplier integration
- Automated quotation system
- Dynamic pricing
- Travel insurance integration
- Visa processing assistance

## 13. Acceptance Criteria

### 13.1 User Acceptance
- All roles can successfully login and access authorized features
- Enquiry form submits correctly with email notifications
- Admin can manage all content types
- Public website is responsive and functional
- APIs return correct responses

### 13.2 Performance Acceptance
- Page load times meet requirements
- API response times within limits
- System handles expected user load

### 13.3 Security Acceptance
- No critical vulnerabilities
- All data is encrypted at rest
- Authentication and authorization work correctly
- Regular security audits pass

## 14. Testing Requirements

### 14.1 Unit Testing
- Model tests
- Controller tests
- Service tests
- Repository tests
- Helper functions

### 14.2 Integration Testing
- API endpoint tests
- Database integration tests
- Email notification tests
- File upload tests

### 14.3 End-to-End Testing
- User workflows
- Enquiry lifecycle
- Content management workflows
- Authentication flows

### 14.4 Performance Testing
- Load testing
- Stress testing
- Database query performance
- API response times

## 15. Documentation Requirements

### 15.1 Technical Documentation
- API documentation (OpenAPI/Swagger)
- Database documentation
- Code comments
- Architecture diagrams
- Deployment guides

### 15.2 User Documentation
- Admin user guide
- Sales agent guide
- Content manager guide
- Customer guide

## 16. Project Timeline

### 16.1 Development Phases
- Phase 1: Core Setup (2 weeks)
- Phase 2: User Management (2 weeks)
- Phase 3: Enquiry Management (3 weeks)
- Phase 4: Content Management (4 weeks)
- Phase 5: Frontend Website (3 weeks)
- Phase 6: Dashboard Development (2 weeks)
- Phase 7: API Development (2 weeks)
- Phase 8: Testing & QA (3 weeks)
- Phase 9: Deployment (1 week)

**Total Estimated Time: 22 weeks**

## 17. Risk Assessment

### 17.1 Technical Risks
- Third-party API changes
- Database performance issues
- Security vulnerabilities
- Scalability challenges

### 17.2 Mitigation Strategies
- Regular code reviews
- Comprehensive testing
- Security audits
- Performance monitoring
- Backup systems

## 18. Success Criteria

### 18.1 Project Success Metrics
- All functional requirements implemented
- Non-functional requirements met
- User acceptance testing passed
- Security audit passed
- Performance benchmarks achieved
- Documentation complete
- Deployment successful