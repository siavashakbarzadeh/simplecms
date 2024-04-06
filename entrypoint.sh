#!/bin/bash

# Setup Laravel Schedule Run
echo "* * * * * cd /var/www/html && php artisan schedule:run >> /var/log/cron.log 2>&1" | crontab -

# Start cron
service cron start

# Start Apache in the foreground
exec apache2-foreground
