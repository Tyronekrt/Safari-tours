# Safari Tours - Render Deployment Guide

This guide will help you deploy your Safari Tours Laravel application to Render.com using Docker. Render doesn't support native PHP runtime in Blueprints, so we use Docker for deployment.

## Prerequisites

- A GitHub account with your Safari Tours code pushed to a repository
- A Render.com account (free tier)
- Basic knowledge of Git and command line
- Docker installed locally (for testing)

## Step 1: Prepare Your Code

### 1.1 Ensure all files are committed
```bash
git add .
git commit -m "Add Docker configuration for Render deployment"
git push origin main
```

### 1.2 Configuration Files

The following files have been created/updated for Render deployment:

- `Dockerfile` - Docker image configuration for Laravel
- `render.yaml` - Render service configuration using Docker
- `.dockerignore` - Files to exclude from Docker build
- `docker-compose.yml` - Local development with Docker
- `.env.example` - Environment variables template
- `public/.htaccess` - Apache configuration with security headers

## Step 2: Test Locally with Docker (Optional but Recommended)

### 2.1 Build and run with Docker Compose
```bash
docker-compose up -d
```

### 2.2 Run migrations
```bash
docker-compose exec app php artisan migrate
```

### 2.3 Access the application
- Open http://localhost:8000 in your browser

### 2.4 Stop containers
```bash
docker-compose down
```

## Step 3: Set Up Render Account

1. Go to [render.com](https://render.com)
2. Sign up for a free account
3. Connect your GitHub account

## Step 4: Deploy to Render

### Option A: Using render.yaml (Recommended)

1. Go to Render Dashboard
2. Click "New +" → "Blueprint"
3. Connect your GitHub repository
4. Render will automatically detect the `render.yaml` file
5. Review the configuration and click "Apply"

### Option B: Manual Setup

### 4.1 Create PostgreSQL Database

1. Go to Render Dashboard
2. Click "New +" → "PostgreSQL"
3. Name: `safari-db`
4. Database: `safari_tours`
5. User: `safari_user`
6. Select "Free" tier
7. Click "Create Database"

### 4.2 Create Web Service

1. Go to Render Dashboard
2. Click "New +" → "Web Service"
3. Connect your GitHub repository
4. Configure the following:

**Build & Deploy:**
- Runtime: `Docker`
- Docker Context: `.`
- Dockerfile Path: `./Dockerfile`

**Environment Variables:**
- `APP_ENV`: `production`
- `APP_DEBUG`: `false`
- `APP_KEY`: (generate with `php artisan key:generate`)
- `APP_URL`: `https://your-app-name.onrender.com`
- `LOG_CHANNEL`: `stack`
- `LOG_LEVEL`: `debug`
- `DB_CONNECTION`: `pgsql`
- `DB_HOST`: (from your PostgreSQL database)
- `DB_PORT`: `5432`
- `DB_DATABASE`: `safari_tours`
- `DB_USERNAME`: (from your PostgreSQL database)
- `DB_PASSWORD`: (from your PostgreSQL database)
- `CACHE_STORE`: `file`
- `SESSION_DRIVER`: `file`
- `QUEUE_CONNECTION`: `sync`
- `MAIL_MAILER`: `smtp`
- `MAIL_HOST`: `smtp.mailtrap.io` (or your SMTP server)
- `MAIL_PORT`: `2525`
- `MAIL_USERNAME`: (your SMTP username)
- `MAIL_PASSWORD`: (your SMTP password)
- `MAIL_ENCRYPTION`: `tls`
- `MAIL_FROM_ADDRESS`: (your email)
- `MAIL_FROM_NAME`: `Safari Tours`

5. Click "Create Web Service"

## Step 5: Update Environment Variables

After deployment, you'll need to update the email credentials:

1. Go to your web service in Render dashboard
2. Click "Environment" tab
3. Update the following variables:
   - `MAIL_USERNAME`: Your actual Mailtrap username
   - `MAIL_PASSWORD`: Your actual Mailtrap password
   - `MAIL_FROM_ADDRESS`: Your actual email address
4. Click "Save Changes"
5. The service will automatically redeploy

## Step 6: Run Database Migrations

The Dockerfile includes a startup script that automatically runs migrations when the container starts. However, if you need to run migrations manually:

1. Go to your web service in Render dashboard
2. Click "SSH" button to access the container
3. Run: `php artisan migrate --force`
4. Exit the SSH session

## Step 7: Configure Email Service

### Using Mailtrap (Recommended for Development)

1. Sign up at [mailtrap.io](https://mailtrap.io)
2. Create a new inbox
3. Get SMTP credentials
4. Update the following environment variables in Render:
   - `MAIL_HOST`: `smtp.mailtrap.io`
   - `MAIL_PORT`: `2525`
   - `MAIL_USERNAME`: (your Mailtrap username)
   - `MAIL_PASSWORD`: (your Mailtrap password)

### Using a Production Email Service

For production, consider using:
- **SendGrid** (free tier available)
- **Mailgun** (free trial available)
- **Amazon SES** (pay as you go)
- **Brevo** (formerly Sendinblue, free tier available)

## Step 8: Storage Configuration

Render's file system is ephemeral. For persistent storage:

### Option A: Use Render Disk (Recommended for Images)

1. Add a disk to your web service in Render dashboard
2. Mount it to `/var/www/html/storage/app/public`
3. Update your `config/filesystems.php` to use the mounted disk

### Option B: Use Cloud Storage (Recommended for Production)

Consider using:
- **AWS S3** (free tier available)
- **Cloudflare R2** (free egress)
- **Backblaze B2** (very affordable)

## Step 9: Access Your Application

1. Once deployment is complete, Render will provide a URL like:
   `https://safari-tours.onrender.com`
2. Access your application using this URL
3. Test the registration and verification flow

## Step 10: Configure Custom Domain (Optional)

1. Purchase a domain (e.g., Namecheap, GoDaddy)
2. In Render dashboard, go to your web service
3. Click "Settings" → "Custom Domains"
4. Add your domain
5. Update DNS records as instructed by Render
6. SSL certificate will be automatically configured

## Troubleshooting

### Build Fails

- Check the build logs in Render dashboard
- Ensure `Dockerfile` is properly configured
- Verify all dependencies are compatible with PHP version
- Check that `.dockerignore` doesn't exclude necessary files
- Ensure Docker context is set correctly (should be `.`)

### Docker Container Issues

- Check container logs in Render dashboard
- Verify startup script is executable
- Ensure database connection is established before migrations run
- Check that Apache is starting correctly

### Database Connection Issues

### Database Connection Issues

- Verify database credentials in environment variables
- Check if database is running and accessible
- Ensure database migrations ran successfully

### Email Not Sending

- Verify SMTP credentials
- Check if Mailtrap/SMTP service is working
- Review application logs for email errors

### Storage Issues

- For file uploads, consider using cloud storage
- Images may be lost on redeployment without persistent storage
- Test file upload functionality thoroughly

## Free Tier Limitations

Render's free tier includes:
- **Web Service**: 512MB RAM, 0.1 CPU
- **Database**: 1GB PostgreSQL
- **Bandwidth**: 100GB per month
- **Sleeps**: After 15 minutes of inactivity (may take ~30 seconds to wake up)

## Scaling

When you're ready to scale:
1. Upgrade to paid tier for better performance
2. Add Redis for caching and session management
3. Use load balancers for high availability
4. Implement queue workers for background jobs

## Monitoring

- Render provides built-in metrics and logs
- Consider integrating with Sentry for error tracking
- Set up uptime monitoring (e.g., UptimeRobot)

## Security Checklist

- [ ] Set `APP_DEBUG=false` in production
- [ ] Use strong `APP_KEY`
- [ ] Configure proper SMTP credentials
- [ ] Enable HTTPS (automatic on Render)
- [ ] Set up regular database backups
- [ ] Monitor logs for suspicious activity
- [ ] Keep dependencies updated

## Support

- Render Documentation: https://render.com/docs
- Laravel Deployment: https://laravel.com/docs/deployment
- For issues specific to this project, check the application logs in Render dashboard.