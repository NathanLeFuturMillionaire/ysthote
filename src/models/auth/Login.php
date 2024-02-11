<?php

// Initialise un namespace
namespace Ysthote\Models\Auth;

require_once('src/libs/database.php');

use Ysthote\Libs\Database\DatabaseConnection;

class Login
{
    public string $email;
    public string $userId;
    public string $password;
    public string $isConfirmed;
}

class LoginRepository
{
    public DatabaseConnection $connection;
    /**
     * Check if the email address entered does exist
     * @param string $email The email address to check
     * @return int Return a number, 1 if the email address does exist
     */
    public function ChecksIfEmailAddressEntryExists(string $email): int
    {
        $statement = $this->connection->getConnection()->prepare("SELECT email FROM user_accounts WHERE email = :email");
        $statement->execute([
            'email' => $email,
        ]);
        return $statement->rowCount();
    }

    public function getUserID(string $email): Login
    {
        $statement = $this->connection->getConnection()->prepare("SELECT id, email FROM user_accounts WHERE email = :email");
        $statement->execute([
            'email' => $email,
        ]);
        $row = $statement->fetch();
        $login = new Login();
        $login->userId = $row['id'];
        $login->email = $row['email'];
        return $login;
    }

    public function ChecksIfThePersonTryingToConnectHasAlreadyFilledoutTheirProfile(string $email): int
    {
        $statement = $this->connection->getConnection()->prepare("SELECT u.email email, p.id_user idUser FROM profil p INNER JOIN user_accounts u ON u.id = p.id_user WHERE u.email = :email");
        $statement->execute([
            'email' => $email,
        ]);
        return $statement->rowCount();
    }

    public function AddUserInformationInProfile(string $idUser): bool
    {
        $statement = $this->connection->getConnection()->prepare("INSERT INTO profil(id_user) VALUES(:idUser)");
        return $statement->execute([
            'idUser' => $idUser,
        ]);
    }

    public function GetPasswordColumn(string $idUser): Login
    {
        $statement = $this->connection->getConnection()->prepare("SELECT p.id_user id_user, p.pass pass, u.is_confirmed is_confirmed, u.email email FROM profil p INNER JOIN user_accounts u ON u.id = p.id_user WHERE p.id_user = :idUser");
        $statement->execute([
            'idUser' => $idUser,
        ]);
        $row = $statement->fetch();
        $login = new Login();
        $login->userId = $row['id_user'];
        $login->password = $row['pass'];
        $login->isConfirmed = $row['is_confirmed'];
        $login->email = $row['email'];
        return $login;
    }
}