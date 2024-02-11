<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

## Запуск через Docker

### 1 - Открыть Docker
### 2 - Переименовать .env.example-docker в .env
        docker-compose up -d
----

    docker exec -it tdkomplekt_app bash

----

        composer install

        php artisan key:generate

        php artisan migrate

        php artisan storage:link

----
Форма доступна по http://localhost:8876/

---
Файлы сохраняются 

    storage/app/public/users

----


## Запуск без Docker'a

        npm install
        composer install
        php artisan serve
        php artisan key:generate
        php artisan migrate
        php artisan storage:link

        (vite)
