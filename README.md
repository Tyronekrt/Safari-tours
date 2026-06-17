# Safari Tour Management System - Complete MVP

🎉 **A fully functional Laravel 12 Safari Tour Management System MVP that you can run locally!**

## 🚀 Quick Start

### Prerequisites
- PHP 8.3+ 
- MySQL 8.0+
- Composer
- Node.js and NPM

### Installation Steps

1. **Install dependencies:**
```bash
composer install
npm install
```

2. **Configure environment:**
```bash
cp .env.example .env
php artisan key:generate
```

3. **Set up database in `.env`:**
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=safari_tours
DB_USERNAME=root
DB_PASSWORD=your_password
```

4. **Create database:**
```sql
CREATE DATABASE safari_tours CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

5. **Run migrations and seed:**
```bash
php artisan migrate
php artisan db:seed
```

6. **Build assets:**
```bash
npm run build
```

7. **Start server:**
```bash
php artisan serve
```

Visit `http://localhost:8000`

## 🔐 Default Credentials

| Role | Email | Password |
|------|-------|----------|
| Super Admin | admin@safaritours.com | password |
| Sales Agent | sales@safaritours.com | password |
| Customer | john@example.com | password |

## ✨ Features Implemented

### ✅ User Management
- Role-based access control (Super Admin, Admin, Sales Agent, Customer)
- User registration and authentication
- Profile management
- Activity tracking

### ✅ Enquiry System
- Public enquiry submission form
- Admin enquiry management
- Enquiry assignment to sales agents
- Status tracking workflow
- Internal notes system
- Follow-up reminders

### ✅ Package Management
- Create, edit, delete packages
- Package categories
- Destinations association
- Featured and published status
- Package analytics (views, enquiries)

### ✅ Public Website
- Responsive homepage with hero section
- Package browsing and filtering
- Package detail pages
- Enquiry submission form
- About and contact pages

### ✅ Admin Dashboard
- Statistics overview
- Enquiry management interface
- Package management interface
- Recent activities tracking
- Performance metrics

## 📂 Project Structure

```
/home/kelvin/Projects/Safari/
├── app/
│   ├── Models/          # Eloquent models
│   ├── Http/Controllers/ # Controllers
│   └── Http/Middleware/  # Custom middleware
├── database/
│   ├── migrations/       # Database migrations
│   └── seeders/          # Database seeders
├── resources/views/       # Blade templates
├── routes/              # Route definitions
├── public/               # Public assets
└── composer.json         # Dependencies
```

## 📚 Full Documentation

For comprehensive technical documentation, see:
- `SETUP_INSTRUCTIONS.md` - Detailed setup guide
- `SRS.md` - Software Requirements Specification
- `USE_CASE_DIAGRAM.md` - Use case diagrams
- `ERD_DIAGRAM.md` - Entity relationship diagrams
- `DATABASE_SCHEMA_MIGRATIONS.md` - Database schema
- `LARAVEL_PROJECT_STRUCTURE.md` - Architecture
- `REST_API_DOCUMENTATION.md` - API endpoints
- `DEVELOPMENT_ROADMAP.md` - Implementation roadmap
- `RECOMMENDED_PACKAGES_SECURITY.md` - Security practices
- `DEPLOYMENT_STRATEGY.md` - Deployment guide

## 🎯 User Roles

### Super Admin
- Full system access
- User management
- Package management
- Enquiry management
- System configuration

### Admin
- Limited user management
- Package management
- Enquiry management
- Dashboard access

### Sales Agent
- Assigned enquiries
- Status updates
- Note addition
- Dashboard access

### Customer
- Browse packages
- Submit enquiries
- View personal dashboard
- Profile management

## 🧪 Testing the Application

### Test Public Features
1. Visit `http://localhost:8000`
2. Browse packages at `/packages`
3. Submit enquiry at `/enquiry`
4. Check thank you page

### Test Admin Panel
1. Login as admin (`admin@safaritours.com` / `password`)
2. Visit `/admin/dashboard`
3. Create packages at `/admin/packages`
4. Manage enquiries at `/admin/enquiries`

### Test User Dashboard
1. Register new user or login as customer
2. Visit `/dashboard`
3. View personal enquiries
4. Update profile

## 🎨 Technology Stack

- **Backend**: Laravel 12 (PHP 8.3+)
- **Database**: MySQL 8.0+
- **Frontend**: Bootstrap 5
- **Authentication**: Laravel Breeze
- **Authorization**: Spatie Laravel Permission
- **API**: Laravel Sanctum
- **Architecture**: MVC with Repository pattern

## 🔄 Reset Database

```bash
php artisan migrate:fresh
php artisan db:seed
```

## 📊 Database Tables

- `users` - User accounts
- `roles` - User roles
- `permissions` - System permissions
- `safari_packages` - Safari packages
- `package_categories` - Package categories
- `destinations` - Safari destinations
- `enquiries` - Customer enquiries
- `enquiry_notes` - Internal notes
- `enquiry_status_history` - Status tracking
- `follow_up_reminders` - Follow-up system

## 🎉 MVP Features Summary

This MVP provides a solid foundation for a complete safari tour management system with:
- ✅ Fully functional user authentication
- ✅ Complete admin panel
- ✅ Public-facing website
- ✅ Enquiry management workflow
- ✅ Package management system
- ✅ Role-based access control
- ✅ Responsive design
- ✅ Database seeding with sample data
- ✅ Comprehensive documentation

## 🚀 Next Steps

Future enhancements could include:
- Blog management system
- Advanced destination management
- Image upload functionality
- Email notifications
- PDF export functionality
- Mobile app API
- Payment integration
- Live chat support

## 📞 Support

For detailed setup instructions, see `SETUP_INSTRUCTIONS.md`

---

**Built with ❤️ using Laravel 12** 🦁🌍

## Technology Stack

- **Backend Framework**: Laravel 12
- **PHP Version**: PHP 8.3+
- **Database**: MySQL 8.0+
- **Frontend**: Bootstrap 5 / Tailwind CSS
- **Authentication**: Laravel Breeze
- **Authorization**: Spatie Laravel Permission
- **API**: RESTful API with Laravel Sanctum
- **Architecture**: MVC with Repository & Service patterns

## System Modules

### 1. User Management Module
- Role-based access control (Super Admin, Admin, Content Manager, Sales Agent, Customer)
- User registration, authentication, and profile management
- Activity logging and user management
- Role and permission management

### 2. Enquiry Management Module
- Public enquiry submission form
- Enquiry assignment to sales agents
- Status tracking and workflow management
- Internal notes and follow-up reminders
- Export functionality (Excel/PDF)
- Email notifications

### 3. Content Management Module
- Safari package management
- Destination management
- Blog management
- Testimonial management
- Homepage content management

## Documentation Structure

This comprehensive documentation includes the following documents:

### 1. Software Requirements Specification (SRS)
**File**: `SRS.md`
- Complete system requirements
- Functional and non-functional requirements
- Use case descriptions
- Acceptance criteria

### 2. Use Case Diagram Documentation
**File**: `USE_CASE_DIAGRAM.md`
- Detailed use case diagrams
- Actor descriptions
- Use case relationships
- Business rules and system boundaries

### 3. ERD Diagram Documentation
**File**: `ERD_DIAGRAM.md`
- Complete entity relationship diagram
- Detailed table definitions
- Relationship specifications
- Indexing and constraints
- Performance considerations

### 4. Database Schema & Migrations
**File**: `DATABASE_SCHEMA_MIGRATIONS.md`
- Complete Laravel migration files
- Database seeder scripts
- Eloquent model definitions
- Model relationships
- Database backup strategies

### 5. Laravel Project Structure & Architecture
**File**: `LARAVEL_PROJECT_STRUCTURE.md`
- Complete directory structure
- Architecture patterns (MVC, Repository, Service)
- Routing configuration
- Service layer implementation
- Repository pattern examples
- Middleware implementation

### 6. REST API Documentation
**File**: `REST_API_DOCUMENTATION.md`
- Complete API endpoint documentation
- Request/response examples
- Authentication details
- Error handling
- Rate limiting specifications
- API testing examples

### 7. Development Roadmap & Implementation Plan
**File**: `DEVELOPMENT_ROADMAP.md`
- 22-week development timeline
- Phase-by-phase implementation plan
- Resource allocation
- Risk management
- Quality assurance procedures
- Success metrics

### 8. Recommended Packages & Security Best Practices
**File**: `RECOMMENDED_PACKAGES_SECURITY.md`
- Recommended Laravel packages
- Security best practices
- Authentication and authorization
- Input validation and sanitization
- File upload security
- API security
- Database security
- Performance optimization

### 9. Deployment Strategy
**File**: `DEPLOYMENT_STRATEGY.md`
- Server requirements and setup
- Deployment architecture
- CI/CD pipeline configuration
- Monitoring and maintenance
- Backup strategies
- Disaster recovery procedures
- Security hardening
- Rollback procedures

## Quick Start Guide

### Prerequisites
- PHP 8.3+
- MySQL 8.0+
- Composer 2.x
- Node.js 18+
- Redis 7.0+ (optional, for caching)

### Installation Steps

1. **Clone the Repository**
```bash
git clone https://github.com/yourusername/safari-tour-management.git
cd safari-tour-management
```

2. **Install Dependencies**
```bash
composer install
npm install
```

3. **Environment Setup**
```bash
cp .env.example .env
php artisan key:generate
```

4. **Database Setup**
```bash
# Update .env with your database credentials
# Then run migrations
php artisan migrate
php artisan db:seed
```

5. **Build Assets**
```bash
npm run build
```

6. **Start Development Server**
```bash
php artisan serve
```

7. **Access Application**
```
http://localhost:8000
```

### Default Credentials

**Super Admin:**
- Email: admin@safaritours.com
- Password: password

**Sales Agent:**
- Email: sales@safaritours.com
- Password: password

## Development Workflow

### Code Quality Standards
- Follow PSR-12 coding standards
- Use PHPDoc for documentation
- Implement type hinting
- Follow SOLID principles
- Code review for all commits

### Testing
```bash
# Run all tests
php artisan test

# Run with coverage
php artisan test --coverage

# Run specific test
php artisan test --filter EnquiryTest
```

### Code Style
```bash
# Fix code style
./vendor/bin/pint

# Static analysis
./vendor/bin/phpstan analyse
```

## Security Guidelines

### Never Commit to Version Control
- `.env` file
- Database credentials
- API keys and secrets
- SSL certificates
- Private keys

### Always Use
- HTTPS in production
- Prepared statements (ORM handles this)
- Input validation
- CSRF protection
- Secure password hashing
- SSL for database connections

## Deployment Process

### Staging Deployment
1. Push to `develop` branch
2. CI/CD runs tests
3. Automated deployment to staging
4. Manual testing on staging
5. Approval for production

### Production Deployment
1. Create release branch from `main`
2. Run final tests
3. Deploy to production
4. Monitor for issues
5. Merge release back to main

## Support and Maintenance

### Monitoring
- Application monitoring (Sentry)
- Uptime monitoring (Uptime Robot)
- Performance monitoring (New Relic)
- Log management (Loggly)

### Backups
- Daily database backups
- Weekly full backups
- Monthly backup cleanup
- Regular backup testing

### Updates
- Monthly dependency updates
- Security patches as needed
- Feature updates quarterly
- Annual major upgrades

## Project Status

- ✅ Requirements Analysis
- ✅ System Design
- ✅ Database Design
- ✅ Architecture Planning
- ✅ API Design
- ✅ Documentation Complete
- ⏳ Implementation (per Development Roadmap)
- ⏳ Testing (Phase 8)
- ⏳ Deployment (Phase 9)

## Contributing

This is a comprehensive documentation set for building the Safari Tour Management System. When implementing:

1. Follow the architecture patterns outlined
2. Adhere to security best practices
3. Use the recommended packages
4. Follow the development roadmap
5. Implement proper testing
6. Follow deployment procedures

## License

This documentation and the associated project are provided for educational and professional development purposes.

## Contact

For questions about this documentation or implementation guidance, please refer to the specific documentation files for detailed information on each aspect of the system.

---

**Documentation Version**: 1.0  
**Last Updated**: 2026-06-15  
**Laravel Version**: 12  
**PHP Version**: 8.3+  
**Status**: Production-Ready Documentation Complete