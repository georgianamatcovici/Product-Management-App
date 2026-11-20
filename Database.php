<?php
class Database
{
    public $connection;
    public function __construct($config, $username = null, $password = null)
    {
        $username = $username ?? $config['username'] ?? 'root';
        $password = $password ?? $config['password'] ?? '';

        $dsnConfig = $config;
        unset($dsnConfig['username'], $dsnConfig['password']);

        $dsn = 'mysql:' . http_build_query($dsnConfig, '', ';');
        $this->connection = new PDO($dsn, $username, $password, [PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC]);
    }
    public function query($query, $params = [])
    {
        $statement = $this->connection->prepare($query);
        $statement->execute($params);

        return $statement;
    }
}
