<?php

// Init a namespace
namespace Ysthote\Models\Auth;

use Ysthote\Libs\Database\DatabaseConnection;

class ConfirmCode
{
    public string $confirmationCode;
}

class ConfirmAccountCodeRespository
{
    public DatabaseConnection $connection;
    /**
     * Get the user confirmation code
     * 
     * @param string $email the email that will grant us to take the code
     * 
     * @return Enroll
     */
    public function getConfirmationCode(string $email): ConfirmCode
    {
        $statement = $this->connection->getConnection()->prepare("SELECT * FROM user_accounts WHERE email = ?");
        $statement->execute([$email]);
        $row = $statement->fetch();
        $confirmationCode = new ConfirmCode();
        $confirmationCode->confirmationCode = $row['confirmation_code'];
        return $confirmationCode;
    }

    public function confirmAccount(string $email): bool
    {
        $statement = $this->connection->getConnection()->prepare("UPDATE user_accounts SET confirmation_code = confirmed, is_confirmed = 1 WHERE email = ?");
        return $statement->execute([$email]);
    }
}
