# Usa a imagem oficial do PHP com FPM
FROM php:8.2-fpm

# Instala extensões do PHP necessárias para Laravel
RUN apt-get update && apt-get install -y \
    libpq-dev \
    zip \
    unzip \
    curl \
    nginx \
    supervisor \
    && docker-php-ext-install pdo pdo_pgsql

# Define o diretório de trabalho dentro do container
WORKDIR /var/www/html

# Copia os arquivos do projeto para dentro do container
COPY . .

# Instala as dependências do Laravel
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer install --no-dev --optimize-autoloader

# Dá permissão para a pasta storage e bootstrap/cache
RUN chmod -R 777 storage bootstrap/cache

# Copia a configuração do Nginx
COPY .docker/nginx.conf /etc/nginx/sites-available/default

# Define o comando para rodar o Laravel no Railway
CMD service nginx start && php-fpm
