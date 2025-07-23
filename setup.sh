#!/bin/bash

# CRM Cámara de Comercio - Setup Script
# This script automates the setup process for the CRM system

echo "🏢 CRM Cámara de Comercio - Setup Script"
echo "========================================="

# Check if composer is installed
if ! command -v composer &> /dev/null; then
    echo "❌ Composer is not installed. Please install Composer first."
    exit 1
fi

# Check if npm is installed
if ! command -v npm &> /dev/null; then
    echo "❌ NPM is not installed. Please install Node.js and NPM first."
    exit 1
fi

echo "✅ Prerequisites check passed"

# Install PHP dependencies
echo "📦 Installing PHP dependencies..."
composer install --no-dev --optimize-autoloader

# Install Node dependencies
echo "📦 Installing Node.js dependencies..."
npm install

# Create environment file
if [ ! -f .env ]; then
    echo "⚙️ Creating environment file..."
    cp .env.example .env
    echo "✅ Environment file created. Please configure your database settings in .env"
else
    echo "⚠️ Environment file already exists"
fi

# Generate application key
echo "🔑 Generating application key..."
php artisan key:generate

# Check database connection and run migrations
echo "🗄️ Setting up database..."
read -p "Do you want to run database migrations now? (y/n): " -n 1 -r
echo
if [[ $REPLY =~ ^[Yy]$ ]]; then
    php artisan migrate --force
    echo "✅ Database migrations completed"
    
    read -p "Do you want to seed the database with sample data? (y/n): " -n 1 -r
    echo
    if [[ $REPLY =~ ^[Yy]$ ]]; then
        php artisan db:seed --force
        echo "✅ Database seeded with sample data"
        echo ""
        echo "📋 Default Login Credentials:"
        echo "Admin: admin@camaracomercio.com / password123"
        echo "Collaborator: juan.perez@camaracomercio.com / password123"
        echo "Business: carlos@restauranteelbueno.com / password123"
    fi
fi

# Create storage link
echo "🔗 Creating storage link..."
php artisan storage:link

# Build assets
echo "🎨 Building frontend assets..."
npm run build

echo ""
echo "🎉 Setup completed successfully!"
echo ""
echo "📋 Next Steps:"
echo "1. Configure your database settings in .env file"
echo "2. Configure mail settings for email notifications"
echo "3. Set up your web server to point to the 'public' directory"
echo "4. Start the development server with: php artisan serve"
echo ""
echo "🌐 Access your CRM system at: http://localhost:8000"
echo ""