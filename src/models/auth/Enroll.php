<?php

// Init a namespace
namespace Ysthote\Models;

require_once('src/libs/database.php');

use Ysthote\Libs\Database\DatabaseConnection;

class Enroll
{
    public string $email;
    public string $confirmationCode;
    public string $isConfirmed;
    public string $uniqueUserIdentifier;
    public string $enrollDate;
}

class EnrollRepository
{
    public DatabaseConnection $connection;

    /**
     * Create a new account
     * 
     * @param string $email The email address
     * @param string $confirmationCoode The confirmation code
     * @return bool Return a bool
     */
    public function createAccount(string $email, string $confirmationCode): bool
    {
        $statement = $this->connection->getConnection()->prepare("INSERT INTO user_accounts(email, confirmation_code, enroll_date) VALUES(?, ?, NOW())");
        return $statement->execute([$email, $confirmationCode]);
    }

    /**
     * Go to see if the user already exists
     * 
     * @param string $email The email to check the existence
     * 
     * @return int return 1 if the account exists and 0 if not
     */
    public function checksIfUserAlreadyExists(string $email): int
    {
        $statement = $this->connection->getConnection()->prepare("SELECT email FROM user_accounts WHERE email = ?");
        $statement->execute([$email]);
        return $statement->rowCount();
    }
}