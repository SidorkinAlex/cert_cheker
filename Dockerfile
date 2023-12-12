FROM php:8.2-fpm-alpine3.18

ENV TIMEZONE            Europe/Moscow
ENV TZ                  $TIMEZONE


ENV LANG ru_RU.UTF-8
ENV LANGUAGE ru_RU:en
ENV LC_ALL ru_RU.UTF-8




COPY ./cert_checker/ /var/www/app



WORKDIR /var/www/app


ENTRYPOINT ["php","-f", "main.php"]