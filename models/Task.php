<?php

namespace Models;

use Lib\DB;

class Task
{
    protected DB $db;

    public function __construct()
    {
        $this->db = (new DB);
    }

    public function getCount()
    {
        return $this->db->query("SELECT count(id) as count FROM task");
    }

    public function getList( string $limit, string $offset, string $order, string $by )
    {
        return $this->db->query("
                SELECT user_name,email,text,id,status,text_change
                FROM task 
                ORDER BY {$order} {$by}
                LIMIT {$limit} 
                OFFSET {$offset}
        ");
    }

    public function getById( int $id )
    {
        return $this->db->query("
                SELECT text,id,status,text_change
                FROM task 
                WHERE id = {$id}
        ")->fetch();
    }

    public function add( string $userName, string $email, string $text )
    {
        return $this->db->query("
            INSERT INTO task (id,user_name,email,text)
            VALUES (
                     DEFAULT,
                    '$userName',                 
                    '$email',                 
                    '$text'        
            )"
        );
    }

    public function update( string $text, string $status, int $id, string $textChange )
    {
        return $this->db->query("
            UPDATE task
            SET text = '{$text}',
                status = {$status},
                text_change = {$textChange}
            WHERE id = {$id};
        ");
    }
}