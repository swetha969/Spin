<?php

/**
 * Simple wrapper for PDO to make it easy to pass a single
 * instance around.
 *
 * Class DB
 */
class DB
{
    protected $connection;

    public function __construct($type, $host, $dbname, $user, $pass)
    {
        $this->connection = new PDO($type . ':host=' . $host . ';dbname=' . $dbname, $user, $pass);
    }

    public function getConnection()
    {
        return $this->connection;
    }
}
