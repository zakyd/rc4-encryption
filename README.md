# RC4 ENCRYPTION


## HOW TO INSTALL

You will need [composer](https://getcomposer.org/)

1. Download or clone this repository
2. After that do `composer install` on root path, eg. it must be inside `rc4-encryption` folder
3. Then copy `.env.example` to `.env` and fill with your server configuration
4. Run `php artisan key:generate` to generate `APP_KEY`
5. Run `php artisan storage:link` to create storage symbolic link
6. Run `php artisan serve` to serve your application. This command will start a development server at `http://localhost:8000`
7. Now you are ready to rock!

Read also [Laravel Docs](https://laravel.com/docs/5.8)