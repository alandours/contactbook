# ContactBook

Contact book made with Laravel and MySQL.

## How to use

Clone the GitHub repo

```
$ git clone https://github.com/alandours/contactbook.git
```

Install Composer dependencies

```
$ composer install
```

Copy ``.env.example`` and rename it ``.env``

```
$ cp .env.example .env
```

Generate an app key

```
$ php artisan key:generate
```

Create a new MySQL database and configure the ``.env`` file accordingly

```
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=
DB_USERNAME=
DB_PASSWORD=
```

Migrate the database

```
$ php artisan migrate
```

Run app

```
$ php artisan serve
```