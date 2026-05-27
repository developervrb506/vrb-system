FROM php:7.4-apache

RUN docker-php-ext-install mysqli pdo pdo_mysql

# short tags
RUN echo "short_open_tag=On" > /usr/local/etc/php/conf.d/short-tags.ini

# auto prepend config
RUN echo "auto_prepend_file=/var/www/html/config.php" > /usr/local/etc/php/conf.d/auto-prepend.ini
