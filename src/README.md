## AD-ApiGw
A single entry point for interactions between an apps. The API gateway can manage API

## Installation
```bash
#create .env
$ cp .env.example test
#connect your database using modify .env
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=33060
    DB_DATABASE=apigw
    DB_USERNAME=pol
    DB_PASSWORD=secret
$ cp .env.example test
#install composer
$ composer install
#run this command to make JWT secret
$ php artisan jwt:secret
```

## Run application
```bash
#run this command to run application in your localhost:port
php -S localhost:8000 -t public
```