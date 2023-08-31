Установка:

1) Создать .env и вписать свои данные для подключения к БД
2) composer install
3) php artisan key:generate
4) php artisan migrate
5) php artisan app:extract_post_comments_data (заполняет таблицы данными)
6) php artisan serve
7) http://127.0.0.1:8000
