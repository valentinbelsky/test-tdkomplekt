<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

## Запуск через Docker
### Скопировать и переназвать .env.example-docker в .env

    docker-compose up -d
----

    docker exec -it tdkomplekt_app bash

----

        composer install

        php artisan key:generate

        php artisan migrate

        php artisan storage:link

----

