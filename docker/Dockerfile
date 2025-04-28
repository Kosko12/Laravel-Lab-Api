# Wybieramy oficjalny obraz PHP z rozszerzeniami potrzebnymi do Laravel
FROM php:8.2-fpm

# Ustawiamy katalog roboczy
WORKDIR /var/www

# Instalujemy potrzebne zależności
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    libsqlite3-dev \
    sqlite3 \
    && docker-php-ext-install pdo pdo_sqlite zip

# Instalujemy Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Kopiujemy pliki aplikacji do kontenera
COPY . .

# Instalujemy zależności aplikacji Laravel
RUN composer install --no-dev --optimize-autoloader

# Ustawiamy prawa do katalogów storage i bootstrap/cache
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

# Ustawiamy użytkownika
USER www-data

# Domyślny port (możesz potem wystawić 8000)
EXPOSE 8000

# Domyślna komenda – uruchom serwer PHP w trybie developerskim
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]

