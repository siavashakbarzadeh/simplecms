FROM php:8.2-apache

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    libzip-dev \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libwebp-dev \
    libxpm-dev \
    cron \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg --with-webp --with-xpm \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# Enable Apache modules
RUN a2enmod rewrite ssl

WORKDIR /var/www/html

# Copy the application files to the container
COPY . /var/www/html


# Change ownership of our applications
RUN chown -R www-data:www-data /var/www/html

# Ensure that the bootstrap/cache directory exists and is writable
RUN mkdir -p bootstrap/cache && \
    chown -R www-data:www-data bootstrap/cache && \
    chmod -R 775 bootstrap/cache


# Clear config and cache
RUN php artisan config:clear && \
    php artisan cache:clear

# Configure SSL
COPY apache.conf /etc/apache2/sites-available/000-default.conf

# Expose port
EXPOSE 8080

# Adjust Apache to listen on the provided PORT environment variable
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf
RUN sed -i 's/Listen 80/Listen ${PORT}/g' /etc/apache2/ports.conf
RUN sed -i 's/<VirtualHost *:80>/<VirtualHost *:${PORT}>/g' /etc/apache2/sites-available/000-default.conf

# Copy the entrypoint script
COPY entrypoint.sh /usr/local/bin/

# Make the entrypoint script executable
RUN chmod +x /usr/local/bin/entrypoint.sh

# Set the entrypoint script to be executed
ENTRYPOINT ["entrypoint.sh"]
