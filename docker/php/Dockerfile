FROM php:8.1-fpm AS php

RUN docker-php-ext-install mysqli
RUN docker-php-ext-install pdo_mysql

#Install pdo_pgsql
RUN apt-get update && apt-get install -y libpq-dev
RUN docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql
RUN docker-php-ext-install pdo pdo_pgsql

# Install ext-zip
RUN apt-get update && apt-get install -y \
    zlib1g-dev \
    libzip-dev
RUN docker-php-ext-install zip

# Install ext-imap
RUN apt-get update && apt-get install -y libc-client-dev libkrb5-dev && rm -r /var/lib/apt/lists/*
RUN docker-php-ext-configure imap --with-kerberos --with-imap-ssl \
    && docker-php-ext-install imap

# Install ext-gd
RUN apt-get update && apt-get install -y \
            libfreetype6-dev \
            libjpeg62-turbo-dev \
            libpng-dev \
        && docker-php-ext-configure gd --with-freetype --with-jpeg \
        && docker-php-ext-install -j$(nproc) gd

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# NodeJS
RUN curl -sL https://deb.nodesource.com/setup_14.x | bash -
RUN apt-get install -y nodejs
RUN npm install

# Install nano
RUN apt-get update
RUN apt-get install -y nano

# IMAGE RUN CRONJOB
FROM php AS cron

RUN apt-get update
RUN apt-get install -y cron
COPY cron/laravel /etc/cron.d/laravel
RUN chmod 0644 /etc/cron.d/laravel
RUN crontab /etc/cron.d/laravel
CMD ["cron", "-f", "./start.sh"]


# IMAGE RUN QUEUE
FROM cron AS queue

RUN apt-get update
RUN apt-get install -y --no-install-recommends supervisor
COPY supervisor/supervisord.conf /etc/supervisor
COPY supervisor/laravel.conf /etc/supervisor/conf.d
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/supervisord.conf"]

EXPOSE 9000
