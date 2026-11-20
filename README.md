## 1. Clone the repo

Run in your terminal:

```bash
git clone https://github.com/georgianamatcovici/Product-Management-App.git
cd Product-Manegement-App
```

## 2. Import the database

- Open TablePlus and connect to the MySQL server.
- Create a new database named `myapp`.
- Import the `database.dump` file into this database (**File → Import → From SQL Dump**).

## 3. Configure the database connection

Create a `config.php` file in the root directory of the project and add the code:

```php
<?php

return [
    'database' => [
        'host' => 'localhost',
        'port' => 3306,
        'dbname' => 'myapp',
        'charset' => 'utf8mb4',
        'username' => 'root',
        'password' => ''
    ]
];
```

## 4. Start the server

```bash
php -S localhost:8888
```
