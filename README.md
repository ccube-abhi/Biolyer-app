
"🚀 Starting Laravel Project Setup..."

# Step 1: Install dependencies
git clone <your-repo-url>
cd <project-folder>
composer install

# Step 2: Copy .env file
if [ ! -f ".env" ]; then
    echo "⚙️ Copying .env.example to .env..."
    cp .env.example .env
else
    echo "✅ .env already exists"
fi

# Step 3: Generate app key
echo "🔑 Generating application key..."
php artisan key:generate

# Step 4: Set JWT secret
echo "🔐 Generating JWT secret..."
php artisan jwt:secret

# Step 5: Run database migrations
echo "🧱 Running migrations..."
php artisan migrate

# Optional: Run seeders (uncomment if needed)
# echo "🌱 Running DB seeders..."
# php artisan db:seed

# Step 6: Clear cache
echo "🧹 Clearing config and route cache..."
php artisan config:clear
php artisan cache:clear
php artisan route:clear

