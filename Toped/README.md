## How To Clone ?

1. Clone this project using https or ssh
2. So we are using Laravel Breeze and Tailwind for styling, type the code below

```
composer install
npm install
```

3. Copy `.env.example` file to `.env`(buat file namanya.env) on the root folder. You can type copy `.env.example .env` if using command prompt Windows or cp `.env.example .env` if using terminal, Ubuntu
4. adjust the values that are in the `env` file like db name, db username, db password
5. Set key in `.env` using `php artisan key:generate`
6. Migrate database using `php artisan migrate`
7. After everything has been set, the final step is to type the code below

```
php artisan serve
npm run dev
```
