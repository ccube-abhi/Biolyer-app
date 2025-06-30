#!/bin/bash

echo "🚀 Starting Laravel Project Setup (Docker + Redis + MySQL)..."

# Step 1: Clone the repository
echo "📦 Cloning project..."
git clone https://github.com/ccube-abhi/Biolyer-app.git
cd Biolyer-app || exit

# Step 2: Install PHP dependencies
echo "📦 Installing composer dependencies..."
composer install || docker-compose exec app composer install

# Step 3: Copy .env file
echo "📄 Copying .env.example to .env..."
cp .env.example .env

# Step 4: Update .env for MySQL & Redis (manual or edit below if needed)
echo "⚙️  Ensure .env is configured for Docker MySQL and Redis"

# Step 5: Start Docker containers
echo "🐳 Starting Docker containers..."
Click Docker icon in your macOS menu bar.
Go to Preferences (or Settings)
Navigate to Resources → File Sharing.
Add this path: /Applications/XAMPP/xamppfiles/htdocs/...
docker compose up -d

# Step 6: Generate Laravel application key
echo "🔑 Generating Laravel app key..."
php artisan key:generate

# Step 7: Create MySQL database manually if not exists
echo "🛠️  Ensure the database 'bio-tem' exists (create via MySQL CLI, Adminer, PhpMyAdmin, etc.)"

# Step 8: Set JWT secret
echo "🔐 Generating JWT secret..."
php artisan jwt:secret

# Step 9: Run migrations
echo "🧱 Running database migrations..."
php artisan migrate

# Step 10: Run migrations
php artisan db:seed

# Step 11: Clear cache
echo "🧹 Clearing config and route cache..."
php artisan config:clear
php artisan cache:clear
php artisan route:clear

echo "✅ Laravel setup completed successfully!"
php artisan serve

----------------------------------------------------
# Step 1: Setup Redis 
Add this into your .env file

FCACHE_DRIVER=redis
SESSION_DRIVER=redis
QUEUE_CONNECTION=redis

REDIS_CLIENT=phpredis
REDIS_HOST=redis-test
REDIS_PORT=6379

"⚠️ Set REDIS_HOST=redis-test to match your container name in docker-compose.yml"

# Step 2: Start composer
docker compose build web
docker compose up -d

# Step 2: Test it
Method: GET
URL: http://127.0.0.1:8000/redis-test

