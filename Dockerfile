FROM alpine:3.8

# Installing PHP and its dependencies
RUN apk --update --no-cache add curl php php-curl php-openssl php-json php-phar php-dom php-mbstring php-iconv php-ctype php-tokenizer php-xml php-xmlwriter

# Installing composer & prestissimo
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer 

# Creating directory for the application
RUN mkdir -p /app

WORKDIR /app
