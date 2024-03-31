#!/bin/bash

# Change ownership of all files to 'www-data'
chown -R www-data:www-data /var/www/html

# Set directory permissions recursively to 755 (read, write, execute for owner, read and execute for group and others)
find /var/www/html -type d -exec chmod 755 {} \;

# Set file permissions recursively to 644 (read and write for owner, read for group and others)
find /var/www/html -type f -exec chmod 644 {} \;

# Ensure the 'vendor' directory and its contents have appropriate permissions
# Directories within 'vendor' get 755, files get 644
find /var/www/html/vendor -type d -exec chmod 755 {} \;
find /var/www/html/vendor -type f -exec chmod 644 {} \;

# Start Apache in the foreground
apache2-foreground
