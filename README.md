# FoxEcom Referral Platform

A Laravel-based referral management system for FoxEcom themes with partner dashboard and admin management capabilities.

## ⚠️ Important Note

This application contains some redundant code as it was built on top of an older application source code. Some cleanup and refactoring may be needed for production use.

## 🐳 Docker Setup Instructions

### Prerequisites
- Docker Desktop installed and running
- Git

### Quick Start

1. **Clone the repository**
   ```bash
   git clone <repository-url>
   cd foxecom-referral-platform
   ```

2. **Start the application**
   ```bash
   docker-compose up -d
   ```

3. **Install dependencies and setup database**
   ```bash
   # Install PHP dependencies
   docker-compose exec app composer install

   # Run database migrations
   docker-compose exec app php artisan migrate

   # Seed the database with sample data
   docker-compose exec app php artisan db:seed
   ```

4. **Create storage link for file uploads**
   ```bash
   docker-compose exec app php artisan storage:link
   ```

5. **Access the application**
   - Main application: http://localhost:8080
   - phpMyAdmin: http://localhost:8081

### 🔑 Default Login Credentials

After running the seeders, you can login with:

**Admin Account (account_type = 2):**
- Email: `admin@foxecom.com`
- Password: `password123`

**Partner Accounts (account_type = 1):**
- Various seeded partner accounts with email format: `user@example.com`
- Password: `password123`

### 📁 Application Structure

- **Partners (account_type = 1)**: Can submit referral forms and view their dashboard
- **Admin/Manager (account_type = 2)**: Can manage all referral forms, view reports, and manage client dashboards

### 🛠️ Development Commands

```bash
# View logs
docker-compose logs -f app

# Clear caches
docker-compose exec app php artisan cache:clear
docker-compose exec app php artisan config:clear
docker-compose exec app php artisan route:clear

# Run migrations
docker-compose exec app php artisan migrate

# Fresh database with seeders
docker-compose exec app php artisan migrate:fresh --seed

# Access container shell
docker-compose exec app bash
```

### 🗄️ Database Access

- **Host**: localhost
- **Port**: 3307
- **Database**: bringlu_db
- **Username**: bringlu_user
- **Password**: bringlu_password

### 📊 Features

- **Partner Dashboard**: Submit and track referral forms
- **Admin Dashboard**: Manage all referrals and view reports
- **Client Management**: Admin can manage individual partner dashboards
- **Reports**: Quarterly commission and referral reports
- **File Uploads**: Support for referral proof attachments

### 🔧 Troubleshooting

If you encounter issues:

1. **Restart containers**
   ```bash
   docker-compose down
   docker-compose up -d
   ```

2. **Rebuild containers**
   ```bash
   docker-compose down
   docker-compose build --no-cache
   docker-compose up -d
   ```

3. **Check container status**
   ```bash
   docker-compose ps
   ```

### 🧹 Code Cleanup Notes

This application was built on top of existing code and contains some redundant elements that should be cleaned up:

- Legacy advert-related models and controllers (AdvertController, Advert model, etc.)
- Unused middleware and routes
- Old authentication flows
- Redundant database tables and migrations
- Legacy view files and components

For production deployment, consider refactoring to remove unused code and optimize the application structure.