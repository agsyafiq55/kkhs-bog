FROM php:8.2-cli-bookworm

RUN apt-get update && apt-get install -y \
    default-mysql-client \
    git \
    libicu-dev \
    libonig-dev \
    libzip-dev \
    unzip \
    && docker-php-ext-install \
    bcmath \
    intl \
    mbstring \
    pcntl \
    pdo_mysql \
    zip \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/local/bin/composer

WORKDIR /var/www/html

CMD ["php", "-v"]
