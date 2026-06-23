# Safari Tour Management System - Deployment Strategy

## 1. Deployment Overview

This document outlines the comprehensive deployment strategy for the Safari Tour Management System, covering development, staging, and production environments.

### 1.1 Deployment Environments

#### Development Environment
- **Purpose**: Local development and testing
- **Server**: Local machine (Laragon/XAMPP/Docker)
- **Database**: Local MySQL
- **URL**: http://localhost:8000
- **Debug Mode**: Enabled
- **Error Reporting**: All errors displayed

#### Staging Environment
- **Purpose**: Pre-production testing
- **Server**: Cloud VPS (DigitalOcean/AWS EC2)
- **Database**: Production-like MySQL instance
- **URL**: staging.safaritours.com
- **Debug Mode**: Disabled
- **Error Reporting**: Log errors only

#### Production Environment
- **Purpose**: Live application
- **Server**: Cloud VPS (DigitalOcean/AWS EC2) with load balancing
- **Database**: Production MySQL with replication
- **URL**: www.safaritours.com
- **Debug Mode**: Disabled
- **Error Reporting**: Log errors only, send alerts

## 2. Server Requirements

### 2.1 Production Server Specifications

**Minimum Requirements:**
- **CPU**: 2 cores
- **RAM**: 4GB
- **Storage**: 80GB SSD
- **OS**: Ubuntu 22.04 LTS

**Recommended Requirements:**
- **CPU**: 4 cores
- **RAM**: 8GB
- **Storage**: 160GB SSD
- **OS**: Ubuntu 22.04 LTS

### 2.2 Software Requirements

#### Web Server
- **Option 1**: Apache 2.4 with mod_php
- **Option 2**: Nginx 1.24 with PHP-FPM

#### PHP Requirements
- PHP 8.3+
- Required Extensions:
  - php-fpm
  - php-mysql
  - php-xml
  - php-mbstring
  - php-curl
  - php-zip
  - php-bcmath
  - php-intl
  - php-gd
  - php-redis

#### Database
- MySQL 8.0+
- InnoDB storage engine
- UTF8MB4 character set

#### Additional Services
- Redis 7.0+ (for caching and queues)
- Node.js 18+ (for asset compilation)
- Composer 2.x
- Git 2.x

### 2.3 SSL Certificate
- SSL certificate required for production
- Use Let's Encrypt for free SSL
- Configure HSTS headers
- Force HTTPS for all connections

## 3. Deployment Architecture

### 3.1 Architecture Diagram

```
                    ┌─────────────────┐
                    │   Load Balancer │
                    │   (Nginx/HAProxy)│
                    └────────┬────────┘
                             │
                    ┌────────▼────────┐
                    │   Application   │
                    │   Server 1      │
                    │   (Nginx/PHP-FPM)│
                    └────────┬────────┘
                             │
                    ┌────────▼────────┐
                    │   Database      │
                    │   Primary       │
                    │   (MySQL)       │
                    └────────┬────────┘
                             │
                    ┌────────▼────────┐
                    │   Database      │
                    │   Replica       │
                    │   (MySQL)       │
                    └─────────────────┘
                    
                    ┌─────────────────┐
                    │   Redis Server  │
                    │   (Cache/Queue) │
                    └─────────────────┘
                    
                    ┌─────────────────┐
                    │   File Storage  │
                    │   (S3/Local)    │
                    └─────────────────┘
```

### 3.2 High Availability Setup

For production deployment, implement high availability:

1. **Load Balancer**: Distribute traffic across multiple application servers
2. **Application Servers**: Multiple instances for horizontal scaling
3. **Database Replication**: Master-slave setup for read scaling
4. **Redis Cluster**: For distributed caching and queue processing
5. **CDN**: For static asset delivery
6. **Monitoring**: Comprehensive monitoring and alerting

## 4. Deployment Process

### 4.1 Pre-Deployment Checklist

**Code Quality:**
- [ ] All tests pass (PHPUnit tests)
- [ ] Code coverage > 80%
- [ ] No PHPStan errors
- [ ] Code follows PSR-12 standards
- [ ] Security audit passed

**Functionality:**
- [ ] All features working correctly
- [ ] No critical bugs
- [ ] Database migrations tested
- [ ] Email functionality tested
- [ ] File uploads tested

**Performance:**
- [ ] Page load time < 3 seconds
- [ ] API response time < 500ms
- [ ] Database queries optimized
- [ ] Caching implemented
- [ ] Assets minified

**Security:**
- [ ] SSL certificate configured
- [ ] Environment variables set
- [ ] Debug mode disabled
- [ ] Error logging configured
- [ ] Backup procedures tested

### 4.2 Deployment Steps

#### Step 1: Server Setup

```bash
# Update server packages
sudo apt update && sudo apt upgrade -y

# Install required packages
sudo apt install nginx mysql-server redis-server git curl unzip -y

# Install PHP and extensions
sudo apt install php8.3 php8.3-fpm php8.3-mysql php8.3-xml php8.3-mbstring php8.3-curl php8.3-zip php8.3-bcmath php8.3-intl php8.3-gd php8.3-redis -y

# Install Composer
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer

# Install Node.js
curl -fsSL https://deb.nodesource.com/setup_18.x | sudo -E bash -
sudo apt-get install -y nodejs
```

#### Step 2: Database Setup

```bash
# Secure MySQL installation
sudo mysql_secure_installation

# Create database and user
sudo mysql -u root -p

CREATE DATABASE safari_tours_production CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER 'safari_user'@'localhost' IDENTIFIED BY 'strong_password';
GRANT ALL PRIVILEGES ON safari_tours_production.* TO 'safari_user'@'localhost';
FLUSH PRIVILEGES;
EXIT;
```

#### Step 3: Application Deployment

```bash
# Clone repository
sudo mkdir -p /var/www/safaritours
cd /var/www/safaritours
sudo git clone https://github.com/yourusername/safari-tour-management.git .

# Set permissions
sudo chown -R www-data:www-data /var/www/safaritours
sudo chmod -R 755 /var/www/safaritours

# Install dependencies
composer install --no-dev --optimize-autoloader
npm install
npm run build

# Configure environment
cp .env.example .env
nano .env

# Generate application key
php artisan key:generate

# Run migrations
php artisan migrate --force

# Cache configuration
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

#### Step 4: Nginx Configuration

```nginx
# /etc/nginx/sites-available/safaritours
server {
    listen 80;
    listen [::]:80;
    server_name safaritours.com www.safaritours.com;
    return 301 https://$host$request_uri;
}

server {
    listen 443 ssl http2;
    listen [::]:443 ssl http2;
    server_name safaritours.com www.safaritours.com;
    root /var/www/safaritours/public;

    # SSL Configuration
    ssl_certificate /etc/letsencrypt/live/safaritours.com/fullchain.pem;
    ssl_certificate_key /etc/letsencrypt/live/safaritours.com/privkey.pem;
    ssl_protocols TLSv1.2 TLSv1.3;
    ssl_ciphers HIGH:!aNULL:!MD5;
    ssl_prefer_server_ciphers on;

    # Security Headers
    add_header X-Frame-Options "SAMEORIGIN" always;
    add_header X-Content-Type-Options "nosniff" always;
    add_header X-XSS-Protection "1; mode=block" always;
    add_header Strict-Transport-Security "max-age=31536000; includeSubDomains" always;

    # Logging
    access_log /var/log/nginx/safaritours_access.log;
    error_log /var/log/nginx/safaritours_error.log;

    # Laravel Configuration
    index index.php;
    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.3-fpm.sock;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

#### Step 5: SSL Certificate Setup

```bash
# Install Certbot
sudo apt install certbot python3-certbot-nginx -y

# Obtain SSL certificate
sudo certbot --nginx -d safaritours.com -d www.safaritours.com

# Set up auto-renewal
sudo certbot renew --dry-run
```

#### Step 6: Queue Worker Setup

```bash
# Create supervisor configuration
sudo nano /etc/supervisor/conf.d/safari-worker.conf

[program:safari-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /var/www/safaritours/artisan queue:work --sleep=3 --tries=3 --max-time=3600
autostart=true
autorestart=true
user=www-data
numprocs=2
redirect_stderr=true
stdout_logfile=/var/www/safaritours/worker.log

# Start supervisor
sudo supervisorctl reread
sudo supervisorctl update
sudo supervisorctl start safari-worker:*
```

#### Step 7: Cron Job Setup

```bash
# Edit crontab for www-data user
sudo crontab -u www-data -e

# Add Laravel scheduler
* * * * * cd /var/www/safaritours && php artisan schedule:run >> /dev/null 2>&1
```

### 4.3 Zero-Downtime Deployment

```bash
# Deploy script using Laravel Deployer
composer require deployer/deployer --dev

# Create deploy.php file
require 'recipe/laravel.php';

set('application', 'Safari Tour Management');
set('repository', 'git@github.com:yourusername/safari-tour-management.git');
set('allow_anonymous_stats', false);

add('shared_dirs', ['storage']);
add('shared_files', ['.env']);
add('writable_dirs', ['storage', 'bootstrap/cache']);

// Deploy to production
task('deploy', [
    'deploy:prepare',
    'deploy:lock',
    'deploy:release',
    'deploy:update_code',
    'deploy:shared',
    'deploy:vendors',
    'deploy:writable',
    'artisan:storage:link',
    'artisan:view:cache',
    'artisan:config:cache',
    'artisan:route:cache',
    'artisan:migrate',
    'deploy:publish',
    'deploy:unlock',
    'deploy:cleanup',
]);
```

## 5. CI/CD Pipeline

### 5.1 GitHub Actions Configuration

```yaml
# .github/workflows/deploy.yml
name: Deploy to Production

on:
  push:
    branches:
      - main

jobs:
  test:
    runs-on: ubuntu-latest
    
    steps:
    - uses: actions/checkout@v3
    
    - name: Setup PHP
      uses: shivammathur/setup-php@v2
      with:
        php-version: '8.3'
        extensions: mbstring, xml, mysql, bcmath, gd, redis
        coverage: xdebug
    
    - name: Install Dependencies
      run: composer install --no-progress --no-interaction --prefer-dist --optimize-autoloader
    
    - name: Copy Environment File
      run: cp .env.example .env
    
    - name: Generate Application Key
      run: php artisan key:generate
    
    - name: Run Tests
      run: vendor/bin/phpunit --coverage-clover=coverage.xml
    
    - name: Upload Coverage
      uses: codecov/codecov-action@v3
      with:
        file: ./coverage.xml

  deploy:
    needs: test
    runs-on: ubuntu-latest
    
    steps:
    - uses: actions/checkout@v3
    
    - name: Deploy to Server
      uses: appleboy/ssh-action@master
      with:
        host: ${{ secrets.SERVER_HOST }}
        username: ${{ secrets.SERVER_USER }}
        key: ${{ secrets.SSH_PRIVATE_KEY }}
        script: |
          cd /var/www/safaritours
          git pull origin main
          composer install --no-dev --optimize-autoloader
          php artisan migrate --force
          php artisan config:cache
          php artisan route:cache
          php artisan view:cache
          sudo supervisorctl restart safari-worker:*
```

### 5.2 Staging Pipeline

```yaml
# .github/workflows/staging.yml
name: Deploy to Staging

on:
  push:
    branches:
      - develop

jobs:
  deploy:
    runs-on: ubuntu-latest
    
    steps:
    - uses: actions/checkout@v3
    
    - name: Deploy to Staging
      uses: appleboy/ssh-action@master
      with:
        host: ${{ secrets.STAGING_SERVER_HOST }}
        username: ${{ secrets.STAGING_SERVER_USER }}
        key: ${{ secrets.SSH_PRIVATE_KEY }}
        script: |
          cd /var/www/safaritours-staging
          git pull origin develop
          composer install --no-dev --optimize-autoloader
          php artisan migrate --force
          php artisan config:cache
          php artisan route:cache
          php artisan view:cache
```

## 6. Monitoring & Maintenance

### 6.1 Application Monitoring

**Recommended Tools:**
- **Sentry**: Error tracking and performance monitoring
- **New Relic**: Application performance monitoring
- **Laravel Telescope**: Local debugging
- **Uptime Robot**: Uptime monitoring
- **Loggly**: Log management

### 6.2 Monitoring Configuration

```bash
# Install Sentry SDK
composer require sentry/sentry-laravel

# Configure Sentry
php artisan sentry:publish --dsn=your-dsn

# Add to app/Providers/AppServiceProvider.php
use Sentry\State\Hub;

public function boot(): void
{
    if (app()->environment('production')) {
        Hub::getCurrent()->bindClient(new \Sentry\Client([
            'dsn' => env('SENTRY_DSN'),
            'environment' => env('APP_ENV'),
        ]));
    }
}
```

### 6.3 Log Management

```php
// Configure centralized logging
// config/logging.php
return [
    'channels' => [
        'stack' => [
            'driver' => 'stack',
            'channels' => ['daily', 'sentry'],
        ],
        'sentry' => [
            'driver' => 'sentry',
            'level' => 'error',
        ],
    ],
];
```

### 6.4 Health Checks

```bash
# Create health check endpoint
# routes/web.php
Route::get('/health', function () {
    return response()->json([
        'status' => 'ok',
        'timestamp' => now(),
        'database' => DB::connection()->getPdo() ? 'connected' : 'disconnected',
        'cache' => Cache::get('health_check') ? 'connected' : 'disconnected',
    ]);
});

# Set up uptime monitoring
# Configure alerts for downtime
```

## 7. Backup Strategy

### 7.1 Automated Backups

```bash
# Install Laravel Backup package
composer require spatie/laravel-backup

# Configure backups
# config/backup.php
return [
    'backup' => [
        'name' => env('APP_NAME'),
        'source' => [
            'files' => [
                'include' => [base_path()],
                'exclude' => [base_path('vendor')],
            ],
            'databases' => [
                'mysql',
            ],
        ],
        'destination' => [
            'filename_prefix' => '',
            'disks' => [
                's3',
            ],
        ],
        'notifications' => [
            'notifications' => [
                \Spatie\Backup\Notifications\Notifications\BackupHasFailed::class,
                \Spatie\Backup\Notifications\Notifications\UnhealthyBackupWasFound::class,
            ],
        ],
    ],
];
```

### 7.2 Backup Schedule

```php
// app/Console/Kernel.php
protected function schedule(Schedule $schedule)
{
    // Daily database backup at midnight
    $schedule->command('backup:run --only-db')->dailyAt('00:00');
    
    // Weekly full backup on Sundays
    $schedule->command('backup:run')->weekly()->sundaysAt('02:00');
    
    // Monthly archive cleanup
    $schedule->command('backup:clean')->monthly();
}
```

### 7.3 Backup Testing

```bash
# Regular backup restoration tests
# Document restoration procedures
# Test backup integrity
# Verify backup frequency
```

## 8. Scaling Strategy

### 8.1 Horizontal Scaling

**When to Scale:**
- CPU utilization > 80% for extended periods
- Memory utilization > 80%
- Response times > 3 seconds
- Database connection pool exhausted

**Scaling Approach:**
1. Add additional application servers
2. Configure load balancer
3. Set up database read replicas
4. Implement Redis clustering
5. Use CDN for static assets

### 8.2 Vertical Scaling

**When to Scale:**
- Single application server under high load
- Database performance bottlenecks
- Memory-intensive operations

**Scaling Approach:**
1. Upgrade server resources (CPU, RAM)
2. Optimize database configuration
3. Implement database indexing
4. Add caching layers
5. Optimize PHP-FPM configuration

## 9. Disaster Recovery

### 9.1 Disaster Recovery Plan

**Backup Locations:**
- Primary: Local server storage
- Secondary: Cloud storage (S3)
- Tertiary: Off-site backup (weekly)

**Recovery Time Objective (RTO):** 4 hours  
**Recovery Point Objective (RPO):** 1 hour

### 9.2 Recovery Procedures

```bash
# 1. Restore database
mysql -u root -p safari_tours_production < backup.sql

# 2. Restore application files
rsync -avz backup-server:/backups/safaritours/ /var/www/safaritours/

# 3. Reinstall dependencies
cd /var/www/safaritours
composer install --no-dev --optimize-autoloader

# 4. Clear and cache
php artisan config:clear
php artisan cache:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache

# 5. Restart services
sudo systemctl restart nginx
sudo systemctl restart php8.3-fpm
sudo supervisorctl restart safari-worker:*
```

### 9.3 Disaster Recovery Testing

- Monthly disaster recovery tests
- Document test results
- Update procedures based on test results
- Train team on recovery procedures

## 10. Security Hardening

### 10.1 Server Security

```bash
# Configure firewall
sudo ufw allow 22/tcp    # SSH
sudo ufw allow 80/tcp    # HTTP
sudo ufw allow 443/tcp   # HTTPS
sudo ufw enable

# Disable root login
sudo nano /etc/ssh/sshd_config
# Set: PermitRootLogin no

# Configure fail2ban
sudo apt install fail2ban -y
sudo systemctl enable fail2ban
sudo systemctl start fail2ban
```

### 10.2 Application Security

```php
// config/app.php
return [
    'debug' => env('APP_DEBUG', false),
    'url' => env('APP_URL', 'https://safaritours.com'),
];

// .env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://safaritours.com

# Secure session configuration
SESSION_SECURE_COOKIE=true
SESSION_HTTP_ONLY=true
```

### 10.3 Regular Security Updates

```bash
# Update packages regularly
sudo apt update && sudo apt upgrade -y

# Update Composer packages
composer update

# Security audit
composer audit

# Regular penetration testing
# Security code reviews
```

## 11. Maintenance Schedule

### 11.1 Daily Tasks
- Monitor application performance
- Check error logs
- Verify backup completion
- Review security alerts

### 11.2 Weekly Tasks
- Review analytics and usage statistics
- Check database performance
- Review and optimize slow queries
- Update dependencies if security patches available

### 11.3 Monthly Tasks
- Complete security audit
- Review and update documentation
- Test disaster recovery procedures
- Review and optimize caching strategy
- Update SSL certificates (if needed)

### 11.4 Quarterly Tasks
- Major dependency updates
- Performance optimization review
- Capacity planning review
- Security assessment
- Disaster recovery testing

## 12. Rollback Procedure

### 12.1 Rollback Steps

```bash
# Rollback application to previous version
cd /var/www/safaritours
git revert HEAD
composer install --no-dev --optimize-autoloader
php artisan migrate:rollback
php artisan config:cache
php artisan route:cache
php artisan view:cache
sudo systemctl restart nginx
sudo systemctl restart php8.3-fpm
```

### 12.2 Database Rollback

```bash
# Rollback specific migration
php artisan migrate:rollback --step=1

# Rollback to specific migration
php artisan migrate:rollback --path=database/migrations/2024_01_01_000000_create_users_table.php
```

### 12.3 Rollback Testing

- Test rollback procedures in staging environment
- Document rollback procedures
- Train team on rollback procedures
- Set up automated rollback triggers

## 13. Post-Deployment Verification

### 13.1 Deployment Checklist

**Functionality:**
- [ ] Homepage loads correctly
- [ ] Login/registration works
- [ ] All main pages accessible
- [ ] Forms submit successfully
- [ ] Emails sent correctly
- [ ] Database operations working

**Performance:**
- [ ] Page load times < 3 seconds
- [ ] API response times < 500ms
- [ ] No database connection errors
- [ ] Cache functioning correctly

**Security:**
- [ ] HTTPS working correctly
- [ ] SSL certificate valid
- [ ] Security headers present
- [ ] Debug mode disabled
- [ ] Error logging working

**Monitoring:**
- [ ] Monitoring configured
- [ ] Error tracking working
- [ ] Uptime monitoring active
- [ ] Backup system operational

This comprehensive deployment strategy ensures a smooth, secure, and reliable deployment of the Safari Tour Management System with proper monitoring, maintenance, and disaster recovery procedures.