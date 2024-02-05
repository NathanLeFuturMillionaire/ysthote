<?php

// Initialise un namespace
namespace Ysthote\Libs\Database;

/**
 * Initialise une nouvelle connexion à la
 * base de données
 */
class DatabaseConnection
{
    public ?\PDO $database = null;

    // Récupère la connexion à la base de données
    public function getConnection() : \PDO
    {
        if($this->database === null) {
            $this->database = new \PDO('mysql:host=localhost;dbname=ysthote;charset=utf8', 'root', '');
        }

        return $this->database;
    }
}