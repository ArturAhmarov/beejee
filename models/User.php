<?php

namespace Models;

use Lib\DB;

class User
{
    protected DB $db;

    public function __construct()
    {
        $this->db = (new DB);
    }

    public function authorization( string $login, string $password )
    {
        $password = md5($password);
        return $this->db->query("
                SELECT id
                FROM users 
                WHERE login = '{$login}' AND password = '{$password}'
        ")->fetch();
    }
}