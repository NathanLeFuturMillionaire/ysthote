<?php

// Init a namespace
namespace Igest\Libs\Database;

/**
 * This class will create a new connection to the database
 */
class DatabaseConnection
{
    public ?\PDO $database = null;
    /**
     * Gets the connection returned by PDO
     * @return PDO
     */
    public function getConnection(): \PDO
    {
        if($this->database === null) {
            $this->database = new \PDO('mysql:host=localhost;dbname=igest;charset=utf8', 'root', '', [\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION]);
        }

        return $this->database;
    }
}