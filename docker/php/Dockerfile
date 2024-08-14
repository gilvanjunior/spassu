FROM php:8.3-fpm-alpine3.19

# Install system dependencies
RUN apk add --no-cache \
    bash \
    curl \
    libpng-dev \
    libzip-dev \
    zlib-dev \
    oniguruma-dev \
    pcre2-dev

RUN set -ex \
    && apk --no-cache add \
    postgresql-dev

# Install PHP extensions
RUN docker-php-ext-install gd zip pdo mbstring pdo_pgsql

# Instala o Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Define o diret?rio de trabalho
WORKDIR /var/www

# Copia os arquivos do projeto Laravel
COPY ./ /var/www

# Cria a pasta logs para o monolog dentro de /var/www/public
RUN mkdir -p /var/www/public/logs

# Cria o arquivo app.log dentro de /var/www/public/logs e define as permissões para 777
RUN touch /var/www/public/logs/app.log && chmod 777 /var/www/public/logs/app.log

# Gera a chave da aplica??o Laravel
#RUN php artisan key:generate

# Gera as tabelas no banco de dados
#RUN php artisan migrate

EXPOSE 9000

CMD bash -c "composer install && php artisan migrate && php artisan key:generate && chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache && php-fpm"