FROM php:7.4-apache
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

RUN apt-get update && apt-get upgrade -y
RUN a2enmod rewrite && service apache2 restart
RUN apt-get install -y \
        libzip-dev \
        zip \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libpng-dev
RUN docker-php-ext-install zip \
  && docker-php-ext-configure gd --with-freetype --with-jpeg \
  && docker-php-ext-install -j$(nproc) gd

RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli

#RUN service apache2 restart
#RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf
#CMD ["/usr/sbin/apache2ctl", "-D", "FOREGROUND"]
#RUN sed -i '/LoadModule rewrite_module/s/^#//g' /usr/local/apache2/conf/httpd.conf
#RUN sed -i '/<Directory \/var\/www\/>/,/<\/Directory>/ s/AllowOverride None/AllowOverride All/' /etc/apache2/apache2.conf

