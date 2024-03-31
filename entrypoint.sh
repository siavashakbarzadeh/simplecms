#!/bin/bash

# Change ownership of the application files
chown -R www-data:www-data /var/www/html

# Start Apache in the foreground
apache2-foreground
