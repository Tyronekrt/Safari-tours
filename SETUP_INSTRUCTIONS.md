# Safari Tour Management System - Setup Instructions

## 🚀 Quick Start Guide

This guide will help you set up and run the Safari Tour Management System on your local machine.

### Prerequisites

- PHP 8.3+ installed
- MySQL 8.0+ installed
- Composer installed
- Node.js and NPM installed

## 📋 Installation Steps

### 1. Install Dependencies

Navigate to the project directory and install required PHP packages:

```bash
cd /home/kelvin/Projects/Safari
composer install
```

### 2. Install Frontend Dependencies

Install Node.js packages for asset compilation:

```bash
npm install
```

### 3. Configure Environment

Create the `.env` file by copying the example:

```bash
cp .env.example .env
```

Edit the `.env` file and configure your database:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=safari_tours
DB_USERNAME=root
DB_PASSWORD=your_password
```

Generate application key:

```bash
php artisan key:generate
```

### 4. Create Database

Create a MySQL database named `safari_tours`:

```sql
CREATE DATABASE safari_tours CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### 5. Run Migrations

Run the database migrations to create all required tables:

```bash
php artisan migrate
```

### 6. Seed the Database

Seed the database with initial data (roles, permissions, sample packages, destinations):

```bash
php artisan db:seed
```

Or run the specific seeder:

```bash
php artisan db:seed --class=RolePermissionSeeder
php artisan db:seed --class=DatabaseSeeder
```

### 7. Build Frontend Assets

Compile the frontend assets:

```bash
npm run build
```

### 8. Start the Development Server

Start the Laravel development server:

```bash
php artisan serve
```

The application will be available at: `http://localhost:8000`

## 🔐 Default Login Credentials

After seeding the database, you can use these credentials:

### Super Admin
- Email: `admin@safaritours.com`
- Password: `password`

### Sales Agent
- Email: `sales@safaritours.com`
- Password: `password`

### Customer
- Email: `john@example.com`
- Password: `password`

## 🌐 Application Features

### Public Website
- **Home**: `http://localhost:8000` - Homepage with featured packages and destinations
- **Packages**: `http://localhost:8000/packages` - Browse all safari packages
- **Enquiry Form**: `http://localhost:8000/enquiry` - Submit safari enquiries

### Admin Panel
- **Dashboard**: `http://localhost:8000/admin/dashboard` - Admin statistics and overview
- **Packages Management**: `http://localhost:8000/admin/packages` - Manage safari packages
- **Enquiries Management**: `http://localhost:8000/admin/enquiries` - Manage customer enquiries

### User Dashboard
- **My Dashboard**: `http://localhost:8000/dashboard` - User profile and enquiry history

## 📊 Database Structure

The application uses the following main tables:

- `users` - User accounts with role-based access
- `roles` - User roles (super_admin, admin, sales_agent, customer)
- `permissions` - System permissions
- `safari_packages` - Safari packages
- `package_categories` - Package categories
- `destinations` - Safari destinations
- `enquiries` - Customer enquiries
- `enquiry_notes` - Internal notes on enquiries
- `enquiry_status_history` - Status change tracking
- `follow_up_reminders` - Follow-up reminders

## 🎯 User Roles and Permissions

### Super Admin
- Full system access
- User management
- Package management
- Enquiry management
- System configuration

### Admin
- User management (limited)
- Package management
- Enquiry management
- Dashboard access

### Sales Agent
- Assigned enquiries
- Status updates
- Note adding
- Dashboard access

### Customer
- Browse packages
- Submit enquiries
- View personal dashboard

## 🛠️ Troubleshooting

### Database Connection Error
If you get a database connection error:
1. Check your MySQL is running
2. Verify database credentials in `.env`
3. Ensure database exists
4. Try restarting MySQL service

### Permission Errors
If you get permission-related errors:
1. Make sure you ran the seeders
2. Check user roles in the database
3. Ensure Spatie Permission package is installed

### Asset Issues
If frontend assets don't load:
1. Run `npm install`
2. Run `npm run build`
3. Clear browser cache

## 🧪 Testing the Application

### Test Public Website
1. Visit `http://localhost:8000`
2. Browse packages
3. Submit an enquiry form
4. Check thank you page

### Test Admin Panel
1. Login as admin (`admin@safaritours.com` / `password`)
2. Visit admin dashboard
3. Create/edit packages
4. Manage enquiries
5. Test status updates and assignments

### Test User Dashboard
1. Register new user or login as customer
2. View dashboard
3. Check enquiry history
4. Update profile

## 🔄 Resetting the Database

If you need to reset the database:

```bash
# Drop all tables and re-run migrations
php artisan migrate:fresh

# Re-seed the database
php artisan db:seed
```

## 📝 Adding New Features

### Adding a New Package
1. Login as admin
2. Navigate to Admin > Packages
3. Click "Add Package"
4. Fill in package details
5. Select destinations
6. Save and publish

### Managing Enquiries
1. Login as admin or sales agent
2. Navigate to Admin > Enquiries
3. View enquiry details
4. Assign to sales agent
5. Update status
6. Add internal notes

## 🎨 Customization

### Changing Colors
Edit the Bootstrap classes in the Blade templates or add custom CSS in:
- `resources/views/layouts/app.blade.php` (public site)
- `resources/views/layouts/admin.blade.php` (admin panel)

### Adding New Pages
1. Create controller method
2. Add route in `routes/web.php`
3. Create Blade view in `resources/views/`

## 📚 Additional Resources

- [Laravel Documentation](https://laravel.com/docs)
- [Bootstrap 5 Documentation](https://getbootstrap.com/docs/5.3/)
- [Spatie Laravel Permission](https://spatie.be/docs/laravel-permission)
- [Tailwind CSS](https://tailwindcss.com/) (Alternative to Bootstrap)

## 🆘 Support

If you encounter any issues:
1. Check the Laravel logs in `storage/logs/`
2. Check PHP error logs
3. Ensure all dependencies are installed
4. Verify database connection
5. Clear Laravel cache: `php artisan cache:clear`

## 🎉 Next Steps

This MVP includes core functionality for:
- ✅ User authentication and authorization
- ✅ Safari package management
- ✅ Enquiry system with workflow
- ✅ Admin dashboard with statistics
- ✅ Public website with responsive design
- ✅ Database seeding with sample data

Future enhancements could include:
- Blog management
- Destination management with maps
- Image upload functionality
- Email notifications
- PDF export functionality
- Mobile app API
- Payment integration
- Live chat support

---

**Ready to start building your safari business! 🦁🌍**