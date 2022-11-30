<?php
namespace Lib;

class DB
{
    CONST HOST = 'localhost';
    CONST DBNAME = 'arturpxq_beejee';
    CONST USERNAME = 'arturpxq_beejee';
    CONST PASSWORD = '2948996Artur.';

    /**
     * @var \PDO $connection
     */
    static $connection = null;

    /**
     * Подключение к БД
     */
    public function connect(){

        self::$connection = new \PDO(
            'mysql:host=' . self::HOST . ';dbname=' . self::DBNAME,
            self::USERNAME,
            self::PASSWORD
        );
    }

    public function query( string $query ) {
        return self::$connection->query( $query );
    }
}