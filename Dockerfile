FROM richarvey/nginx-php-fpm:latest

# Set the webroot
ENV WEBROOT /var/www/html/public
WORKDIR /var/www/html

# Set composer to allow running as root
ENV COMPOSER_ALLOW_SUPERUSER 1

# === ADD THESE LINES TO INSTALL COMPOSER ===
# Download the installer
RUN curl -sS https://getcomposer.org/installer -o /tmp/composer-setup.php
# Install it globally
RUN php /tmp/composer-setup.php --install-dir=/usr/local/bin --filename=composer
# Remove the installer
RUN rm /tmp/composer-setup.php
# ===========================================

# Copy in application code
COPY . .

# === ADD THIS LINE TO MAKE THE SCRIPT EXECUTABLE ===
RUN chmod +x scripts/deploy.sh
# ===================================================

# Run the deploy script
RUN scripts/deploy.sh