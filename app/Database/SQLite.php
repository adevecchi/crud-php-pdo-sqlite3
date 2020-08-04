<?php

namespace App\Database;

final class SQLite
{
    private $connection;
    
    private static $instance = null;

    private function __construct()
    {
        try {
            $this->connection = new \PDO('sqlite:'.$this->getPathDatabase());

            $this->connection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        } 
        catch (\PDOException $e) {
            throw new \Exception($e->getMessage());
        } 
        catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function getConnection(): \PDO
    {
        return $this->connection;
    }

    public static function create(): SQLite
    {
        if (self::$instance === null) {
            self::$instance = new static();
        }

        return self::$instance;
    }

    private function __clone() {}
    private function __wakeup() {}

    private function getPathDatabase(): string
    {
        $path = dirname(dirname(__FILE__));

        if (PHP_OS == 'Linux') 
            return ($path .= '/data/dbsqlite.db');
        
        return ($path .= '\data\dbsqlite.db');   
    }
}