
1. Clone the repo

run in your terminal:

git clone https://github.com/georgianamatcovici/Product-Management-App.git
cd Product-Manegement-App

2.Import the database

open TablePlus and connect to the MySQL server
create a new database named myapp
import the database.dump file into this database (File -> Import -> From SQL Dump)


3.Configure the database connection

create a config.php file in the root directory of the project and add the code:

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

4. Start the server
php -S localhost:8888
