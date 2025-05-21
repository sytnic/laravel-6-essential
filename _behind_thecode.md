Неофициальный код  
https://github.com/seanmayer/laravel-essentials

## 03-Saving files

> Запуск проекта на основе старого проекта

Запуск миграций

    php artisan migrate:fresh --seed

Установка зависимостей

    composer install

> Создание новых фич

Создание новой миграции

    php artisan make:migration AddRoomTypePictures

Создание новой таблицы под хранение фотографий.   
Наполнение созданного файла и запуск миграции.  

    php artisan migrate

Создание папки для хранения файлов

    php artisan storage:link

Создание контроллера и указание на модель

    php artisan make:controller RoomTypeController --resource --model=RoomType

Добавить маршрут в `routes/web.php`.

Создать `views/roomTypes/edit.blade.php` и заполнить содержимым. 

Корректировка контроллера в методах edit и update.  

По адресу `/room_types/1/edit` должно работать прикрепление фото с компа для комнаты.  
Далее будет создаваться дальнейший интерфейс.  

## 
