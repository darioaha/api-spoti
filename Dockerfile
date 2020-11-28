FROM ubuntu:18.04 as src

env DEBIAN_FRONTEND=noninteractive

RUN apt-get update
RUN apt-get dist-upgrade -y

RUN apt-get install -y php7.2
RUN apt-get install -y openssl vim apache2 php7.2-cli php7.2-mysql curl php7.2-curl
RUN apt install -y zip unzip php-zip php-xml php-mbstring php-curl

RUN a2enmod php7.2
RUN a2enmod rewrite

COPY . /var/www/apispoti
WORKDIR /var/www/apispoti

RUN curl https://getcomposer.org/download/1.10.16/composer.phar --output composer.phar
RUN chmod +x composer.phar && mv composer.phar /usr/local/bin/composer

RUN echo "cp .env" \
    && cp .env.tmpl .env

RUN composer config platform.php 7.2 \
    && composer install --no-dev --ignore-platform-reqs --prefer-dist --no-progress --no-suggest --no-interaction \
    && composer dump-autoload --optimize --apcu

FROM ubuntu:18.04

env DEBIAN_FRONTEND=noninteractive

RUN apt-get update
RUN apt-get dist-upgrade -y

RUN apt-get install -y php7.2
RUN apt-get install -y openssl vim apache2 php7.2-cli php7.2-mysql curl php7.2-curl
RUN apt install -y zip unzip php-zip php-xml php-mbstring php-curl

RUN a2enmod php7.2
RUN a2enmod rewrite

COPY --chown=www-data:www-data --from=src /var/www/apispoti /var/www/apispoti
WORKDIR /var/www/apispoti

EXPOSE 80
EXPOSE 443

ENV APACHE_RUN_USER www-data
ENV APACHE_RUN_GROUP www-data
ENV APACHE_LOG_DIR /var/log/apache2

ENV APACHE_LOCK_DIR /var/lock/apache2
ENV APACHE_PID_FILE /var/run/apache2/apache2.pid

RUN sed -i 's;display_errors = .*;display_errors = On;' /etc/php/7.2/apache2/php.ini
RUN sed -i 's;display_errors = .*;display_errors = On;' /etc/php/7.2/cli/php.ini

ADD apache-config.conf /etc/apache2/sites-enabled/000-default.conf
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf
CMD ["/usr/sbin/apache2ctl", "-D", "FOREGROUND"]
