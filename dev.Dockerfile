FROM harbor.uptilt.io/defrostedtuna/laravel-php:7.3-1.1.1
LABEL maintainer="Rick Bennett <rbennett1106@gmail.com>"

RUN apk add --no-cache \
  php7-xdebug

# Enable xdebug for code coverage.
RUN echo zend_extension=xdebug.so >> /etc/php7/conf.d/xdebug.ini

# Start the application
CMD ["/sbin/entrypoint.sh"]