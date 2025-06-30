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
docker-compose up -d

# Step 6: Generate Laravel application key
echo "🔑 Generating Laravel app key..."
docker-compose exec app php artisan key:generate

# Step 7: Create MySQL database manually if not exists
echo "🛠️  Ensure the database 'bio-tem' exists (create via MySQL CLI, Adminer, PhpMyAdmin, etc.)"

# Step 8: Set JWT secret
echo "🔐 Generating JWT secret..."
docker-compose exec app php artisan jwt:secret

# Step 9: Run migrations
echo "🧱 Running database migrations..."
docker-compose exec app php artisan migrate

# Step 10: Run migrations
docker-compose exec app php artisan db:seed

# Step 11: Clear cache
echo "🧹 Clearing config and route cache..."
docker-compose exec app php artisan config:clear
docker-compose exec app php artisan cache:clear
docker-compose exec app php artisan route:clear

echo "✅ Laravel setup completed successfully!"
