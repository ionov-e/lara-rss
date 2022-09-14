FROM php:8.0.6-fpm

WORKDIR "/application"

RUN apt-get update && apt-get install -y lsb-release apt-utils wget gnupg2

#Отключение варнинга для apt-key
ENV APT_KEY_DONT_WARN_ON_DANGEROUS_USAGE=DontWarn

RUN echo "deb http://apt.postgresql.org/pub/repos/apt/ `lsb_release -cs`-pgdg main" \
    | tee  /etc/apt/sources.list.d/pgdg.list

RUN wget --quiet -O - https://www.postgresql.org/media/keys/ACCC4CF8.asc | apt-key add -

RUN apt-get update \
  && apt-get install -y \
             man \
             curl \
             git \
             bash \
             vim \
             zip unzip \
             fonts-freefont-ttf \
             fontconfig \
             dbus \
             openssh-client \
             sendmail \
             libfreetype6-dev \
             libjpeg62-turbo-dev \
             icu-devtools \
             libicu-dev \
             libmcrypt4 \
             libmcrypt-dev \
             libpng-dev \
             zlib1g-dev \
             libxml2-dev \
             libzip-dev \
             libonig-dev \
             graphviz \
             libcurl4-openssl-dev \
             pkg-config \
             libssl-dev \
             libldap2-dev \
             libpq-dev \
             supervisor \
             postgresql-client-13 \
  && pecl install mongodb \
  && echo "extension=mongodb.so" > /usr/local/etc/php/conf.d/mongodb-ext.ini

#xdebug
RUN pecl install xdebug
RUN docker-php-ext-enable xdebug

RUN docker-php-ext-configure intl --enable-intl && \
    docker-php-ext-configure gd --with-freetype --with-jpeg && \
    docker-php-ext-install -j$(nproc) gd && \
    docker-php-ext-install pdo \
        pgsql pdo_pgsql \
        mysqli pdo_mysql \
        intl iconv mbstring \
        zip pcntl \
        exif opcache \
    && docker-php-source delete

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY docker/php-fpm/supervisord.conf /etc/supervisor/supervisord.conf
COPY docker/php-fpm/workers.conf /etc/supervisor/conf.d/workers.conf

EXPOSE 1597