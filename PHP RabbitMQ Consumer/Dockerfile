FROM php:8.2-fpm-alpine

RUN apk add --no-cache rabbitmq-c-dev \
    && docker-php-ext-install amqp \
    && docker-php-ext-install pdo pdo_mysql # Exemplo: Adicione outras extensões que seu projeto possa precisar

WORKDIR /app

COPY composer.json composer.lock ./

RUN composer install --no-dev --optimize-autoloader --no-scripts

COPY . .

EXPOSE 9000

CMD ["php", "consume.php"]