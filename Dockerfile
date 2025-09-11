FROM node:latest AS node
FROM php:8.3-fpm

# set your user name, ex: user=carlos
ARG user=yourusername
ARG uid=1000

COPY --from=node /usr/local/lib/node_modules /usr/local/lib/node_modules
COPY --from=node /usr/local/bin/node /usr/local/bin/node
RUN ln -s /usr/local/lib/node_modules/npm/bin/npm-cli.js /usr/local/bin/npm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip 

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd sockets

# Set working directory
WORKDIR /var/www/html

# Get latest Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Create system user to run Composer and Artisan Commands
RUN useradd -G www-data,root -u $uid -d /home/$user $user
RUN mkdir -p /home/$user/.composer && \
    chown -R $user:$user /home/$user

RUN npm install -g pnpm


COPY . .
COPY .env .env
COPY package.json ./package.json
COPY pnpm-lock.yaml ./pnpm-lock.yaml
#COPY  .composer.json .composer.json ./

RUN pnpm install --force && pnpm run dev 

RUN composer install




USER $user


# Permissões
#RUN useradd -G www-data,root -u $uid -d /var/www/ $user
#RUN php artisan serve --host 0.0.0.0


CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]

