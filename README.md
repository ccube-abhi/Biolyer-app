#!/bin/bash

echo "🚀 Starting Laravel Project Setup (Docker + Redis + MySQL)..."

# Step 1: Clone the repository
echo "📦 Cloning project..."
git clone https://github.com/ccube-abhi/Biolyer-app.git
cd Biolyer-app || exit

# Step 2: Install PHP dependencies
echo "📦 Installing composer dependencies..."
composer install 

# Step 3: Copy .env file
echo "📄 Copying .env.example to .env..."
cp .env.example .env

# Step 4: Update .env for MySQL & Redis (manual or edit below if needed)
echo "⚙️  Ensure .env is configured for Docker MySQL and Redis"
DB_CONNECTION=mysql
DB_HOST=host.docker.internal
DB_PORT=3306
DB_DATABASE=db_name
DB_USERNAME=username
DB_PASSWORD=password

# Step 5: Generate Laravel application key
echo "🔑 Generating Laravel app key..."
php artisan key:generate

# Step 6: Set JWT secret
echo "🔐 Generating JWT secret..."
php artisan jwt:secret

# Step 7: Setup Redis 
Add this into your .env file
REDIS_CLIENT=phpredis
REDIS_HOST=host_name     //redis-test
REDIS_PORT=6379
"⚠️ Set REDIS_HOST=redis-test to match your container name in docker-compose.yml"

# Step 8: Start Docker containers
echo "🐳 Starting Docker containers..."
Click Docker icon in your macOS menu bar.
Go to Preferences (or Settings)
Navigate to Resources → File Sharing.
Add this path: /Applications/XAMPP/xamppfiles/htdocs/...

# Step 9: Start composer
docker compose up -d --build

# Step 10: Run migrations
echo "🧱 Running database migrations..."
docker compose exec web php artisan migrate

# Step 11: Run migrations
docker compose exec web php artisan db:seed

# Step 12: Clear cache
echo "🧹 Clearing config and route cache..."
php artisan config:clear
php artisan cache:clear
php artisan route:clear

# Step 13: Test it
Method: GET
URL: http://localhost:8000/redis-test

Method:POST
http://localhost:8000/api/register

# Step 13: Perform Unit Test Run this command
docker compose exec web php artisan test
-------------------------------------------------

Using the Larastan library for testing and error checking

# Step 1: Intro, Installation and Common Errors
It shows you potential errors in your code with just one terminal command! Or even better - right in your editor. Let's look at what it brings

list is to run the analysis. To do that, run the following command:
./vendor/bin/phpstan analyse folder-name

More info: https://medium.com/@chirag.dave/how-to-get-your-laravel-app-from-0-to-9-with-larastan-5eb70da6e62e
-----------------------------------------------------
Used case of PHP_CodeSniffer
You can use PSR standards or Laravel custom rules. By default, PHPCS uses PSR-12.

./vendor/bin/phpcs --standard=PSR12 folder-name

To automatically fix violations:
./vendor/bin/phpcbf folder-name

If its not worked clear cache and re-run PHPCBF with verbosity
./vendor/bin/phpcbf --standard=PSR12 -v folder-name
