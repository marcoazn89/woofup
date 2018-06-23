FROM php:7.1-apache

RUN a2enmod alias ssl rewrite headers deflate expires

RUN apt-get update && apt-get -y install vim curl && apt-get clean

# Install php's PDO and PDOMySQL Drivers
RUN docker-php-ext-install pdo pdo_mysql

# Install data structures
COPY conf/php.ini /usr/local/etc/php/
RUN pecl install ds

RUN rm -Rf /app
RUN mkdir -p /app/woofup /app/certs

# Update the default apache site with the config we created.
ADD conf/dev-api.woofup.com.hosts.conf /etc/apache2/sites-enabled/000-default.conf

# Add self signed SSL certificate to allow running the site under HTTPS
ADD conf/dev-api-ssl.* /app/certs/

CMD ["apache2-foreground"]
