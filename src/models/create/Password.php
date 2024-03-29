<?php

// Initialise un namespace
namespace Ysthote\Models\Create;

require_once 'src/libs/database.php';

use Ysthote\Libs\Database\DatabaseConnection;

class Password
{
    public string $password;
    public string $email;
    public string $idUser;
}

class CreatePasswordRepository
{
    public DatabaseConnection $connection;

    public function UpdatesUserInformation(string $username, string $password, string $idUser): bool
    {
        $statement = $this->connection->getConnection()->prepare("UPDATE profil SET username = :username, pass = :pass WHERE id_user = :idUser");
        return $statement->execute([
            'username' => $username,
            'pass' => $password,
            'idUser' => $idUser,
        ]);
    }

    public function ChecksIfTheConcernedUserHasAlreadySetTheirPassword(string $idUser): Password
    {
        $statement = $this->connection->getConnection()->prepare("SELECT pass FROM profil WHERE id_user = :idUser");
        $statement->execute([
            'idUser' => $idUser,
        ]);
        $row = $statement->fetch();
        $password = new Password();
        $password->password = $row['pass'];
        return $password;
    }
}
