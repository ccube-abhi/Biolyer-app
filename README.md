# 🧬 Biolyer App - Laravel 11 + Docker + Redis + MySQL

A modern Laravel 11 application pre-configured with Docker, Redis, MySQL, and essential development tools like Larastan, Laravel Pint, PHP_CodeSniffer, Scramble, and Git Hooks.

---

## 🚀 Prerequisites

- Docker & Docker Compose
- Git
- No need to install PHP, Composer, MySQL, or Redis locally – everything runs in Docker containers.

---

## 📦 Project Setup (Using Docker)

### 1. Clone Repository
git https://github.com/ccube-abhi/laravel-base-template
cd laravel-base-template

### 2. Environment Setup
cp .env.example .env

DB_CONNECTION=mysql
DB_HOST=host.docker.internal
DB_PORT=3306
DB_DATABASE=base-temp
DB_USERNAME=root
DB_PASSWORD=secret

REDIS_CLIENT=phpredis
REDIS_HOST=redis-test
REDIS_PORT=6379

### 3. Build and Start Docker Containers
docker compose up -d --build
Make sure Docker has file access permission to your project folder:
macOS: Docker Desktop → Settings → Resources → File Sharing → Add /Applications/XAMPP/xamppfiles/htdocs/...

### 4. Laravel Setup (Inside Docker Container)
# Install dependencies (inside container)
docker compose exec base-temp composer install

# Generate app key and JWT secret
docker compose exec base-temp php artisan key:generate
docker compose exec base-temp php artisan jwt:secret

# Run migrations and seeders
docker compose exec base-temp php artisan migrate
docker compose exec base-temp php artisan db:seed

# Clear cache
docker compose exec base-temp php artisan config:clear
docker compose exec base-temp php artisan route:clear
docker compose exec base-temp php artisan cache:clear

### 5. Test Endpoints
Redis Test
GET http://localhost:8000/redis-test

Register User
POST http://localhost:8000/api/register

### 6. Run Unit Tests
docker compose exec base-temp php artisan test

### 7. Code Quality Tools
Laravel Pint (PSR-12 Formatter)
# Auto-format your code
# Optionally configure .pint.json for custom rules.
vendor/bin/pint

### 8. Larastan (Static Analysis)
# Analyze your Laravel app
vendor/bin/phpstan analyse --memory-limit=512M app

### 9. Larastan (Static Analysis)
# Analyze your Laravel app(folder-name-for-analze)
vendor/bin/phpstan analyse --memory-limit=512M app

### 10. PHP_CodeSniffer
# Check code using PSR-12
vendor/bin/phpcs --standard=PSR12 app
# Auto-fix errors
vendor/bin/phpcbf --standard=PSR12 app
# If you face issues, try clearing cache or re-run with verbose:
vendor/bin/phpcbf --standard=PSR12 -v app

### 11. API Documentation using Scramble
# Usage Instructions
# Add comments using PHPDoc format above your controller methods.
# Scramble will auto-generate OpenAPI spec and UI.
Example:
/**
 * Register a new user.
 */
public function register(RegisterRequest $request)
{
    //code...
}

### 12. Generate API Docs
# php artisan scramble:generate
# Export OpenAPI schema to a JSON api.json file:
# php artisan scramble:export

### 13. Git Hooks with igorsgm/laravel-git-hooks
This project uses igorsgm/laravel-git-hooks to automatically enforce code standards and quality checks before every commit.
🔧 What Happens on Every Commit
When you run git commit, the following actions are automatically triggered:
✅ Laravel Pint — auto-formats code
✅ PHP_CodeSniffer — checks for PSR-12 violations
✅ Optional: Add your own custom scripts in config/git-hooks.php
To manually test the hook logic:
 ./vendor/bin/git-hooks run
