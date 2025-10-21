#!/usr/bin/env bash

# Exit on any error
set -e

# Run migrations
php artisan migrate --force

# Start the server
/start.sh