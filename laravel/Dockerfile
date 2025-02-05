# Use a imagem base do PHP com Apache
FROM php:8.2-apache

# Defina o diretório de trabalho
WORKDIR /var/www/html

# Instale dependências do sistema
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    curl \
    libzip-dev \
    libonig-dev \
    libxml2-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libssl-dev \
    && docker-php-ext-install pdo_mysql zip mbstring exif pcntl bcmath gd

# Instale o Node.js (para compilar assets)
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get install -y nodejs

# Instale o Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copie os arquivos do Laravel para o container
COPY ./laravel /var/www/html

# Defina permissões corretas
RUN chown -R www-data:www-data /var/www/html
RUN chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache /var/www/html/public

# Instale as dependências do PHP (Composer)
RUN composer install --no-dev --optimize-autoloader

# Instale as dependências do JavaScript (Node.js)
RUN npm install

# Compile os assets do front-end (caso use Vite/Laravel Mix)
RUN npm run build

# Copie o arquivo .env e gere a chave do Laravel
COPY ./laravel/.env /var/www/html/.env
RUN php artisan key:generate

# Configure o Apache para apontar para a pasta public/
COPY ./laravel/apache-laravel.conf /etc/apache2/sites-available/000-default.conf
RUN a2enmod rewrite

# Rode as migrations
RUN php artisan migrate --force

# Exponha a porta 80
EXPOSE 80

# Comando para iniciar o Apache
CMD ["apache2-foreground"]
