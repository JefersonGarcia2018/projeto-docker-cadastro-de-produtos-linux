# Estágio de construção (PHP 8.4)
FROM php:8.4-fpm-alpine

# Instalar extensões necessárias (MySQL, GD, etc.)
RUN apk add --no-cache \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    zip \
    libzip-dev \
    unzip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo_mysql gd zip

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copiar arquivos do projeto
COPY . .

# Instalar dependências e otimizar
RUN composer install --no-dev --optimize-autoloader

# Ajustar permissões para o usuário www-data
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

EXPOSE 9000
CMD ["php-fpm"]