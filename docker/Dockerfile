FROM ubuntu:22.04
ARG TIMEZONE="Asia/Dhaka"
ARG BUILD_MODE="dev"

ARG DOMAIN="localhost"
ARG TIMEOUT="600"

ENV DOMAIN="${DOMAIN}" \
    TIMEOUT="${TIMEOUT}" \
    TZ=Asia/Dhaka

ARG DEBIAN_FRONTEND=noninteractive

RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone
RUN apt-get update -y \
    && DEBIAN_FRONTEND="noninteractive" apt-get install -y nginx software-properties-common \
    && apt-get update -y \
    && apt install -y -q software-properties-common \
    && add-apt-repository ppa:ondrej/php \
    && apt install -y php7.4\
    && apt install -y php7.4-fpm\
    && apt-get install -y -q --no-install-recommends \
        git\
        gettext\
        curl \
        php7.4-common \
        php7.4-curl \
        php7.4-zip \
        php7.4-gd \
        php7.4-mysql \
        php7.4-mbstring\
        php7.4-xml\
    && apt-get -y autoremove \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* \
    && curl --silent --fail --location --retry 3 https://getcomposer.org/installer | php -- --version=2.3.7 \
    && echo "export PATH=${PATH}:/var/www/vendor/bin" >> ~/.bashrc \
    && mv composer.phar /usr/local/bin/composer \
    && ln -sf /dev/stdout /var/log/nginx/access.log \
    && ln -sf /dev/stderr /var/log/nginx/error.log \
    && . ~/.bashrc


WORKDIR /var/www

COPY --chown=www-data:www-data ./src/composer.* /var/www/

RUN composerInstallArgs="--ignore-platform-reqs --no-interaction --no-scripts --no-autoloader --prefer-dist" \
    && export composerInstallArgs \
    && if [ "${BUILD_MODE}" = "prod" ]; then \
        composerInstallArgs="${composerInstallArgs} --no-dev" \
        && export composerInstallArgs \
    ;fi \
    && composer install $composerInstallArgs

COPY --chown=www-data:www-data ./src .

RUN chown -R www-data:www-data /var/www storage \
    && chmod -R 755 storage\
    && composerDumpAutoloadArgs="-o" \
    && export composerDumpAutoloadArgs \
    && if [ "${BUILD_MODE}" = "prod" ]; then \
        composerDumpAutoloadArgs="$composerDumpAutoloadArgs --classmap-authoritative" \
        && export composerDumpAutoloadArgs \
    ;fi \
    && composer dump-autoload $composerDumpAutoloadArgs \
    && chown -R www-data:www-data /var/log/nginx \
    && chown -R www-data:www-data /usr/share/nginx \
    && chown -R www-data:www-data /etc/nginx \
    && touch /var/run/nginx.pid \
    && chown -R www-data:www-data /var/run/nginx.pid \
    && touch /var/log/php-fpm.log \
    && chown -R www-data:www-data /var/log/php-fpm.log


COPY ./docker/app/nginx/ /etc/nginx/
RUN envsubst "`env | awk -F = '{printf \" $$%s\", $$1}'`\"" < /etc/nginx/conf.d/default.conf.template > /etc/nginx/conf.d/default.conf \
    && rm -f /etc/nginx/conf.d/*.template

RUN php artisan cache:clear

# Start PHP-FPM & nginx service
CMD service php7.4-fpm start && nginx -g "daemon off;"