FROM defrostedtuna/php-nginx:8.1

# Copy the project files.
COPY . /app

# Install dependencies.
RUN composer install --no-dev --optimize-autoloader

# Set application permissions.
RUN chown -R www:www /app
RUN chmod -R ug+rwx /app/storage /app/bootstrap/cache
RUN chmod -R 774 /app/storage/logs