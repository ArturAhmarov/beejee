<?php
namespace Lib;

class DB
{
    CONST HOST = 'localhost';
    CONST PORT = 5432;
    CONST DBNAME = 'beejee';
    CONST USERNAME = 'root';
    CONST PASSWORD = '123qwe';
    CONST OPTIONS = [];

    /**
     * @var \PDO $connection
     */
    static $connection = null;

    /**
     * Подключение к БД
     */
    public function connect(){

        self::$connection = new \PDO(
            'pgsql:host=' . self::HOST . ';port=' . self::PORT . ';dbname=' . self::DBNAME,
            self::USERNAME,
            self::PASSWORD,
            self::OPTIONS
        );
    }

    public function query( string $query ) {
        return self::$connection->query( $query );
    }
}