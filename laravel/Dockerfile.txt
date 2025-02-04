FROM php:8.3

RUN apt-get update -y && apt-get install -y \
    openssl \
    zip \
    unzip \
    git \
    libonig-dev

# Instala o Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Instala as extensões PDO e mbstring
RUN docker-php-ext-install pdo_mysql mbstring

WORKDIR /app

COPY . /app

# Instala as dependências do Laravel
RUN composer install

# Expor a porta do servidor Laravel
EXPOSE 80

# Comando para rodar as migrações e iniciar o servidor
CMD php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=80