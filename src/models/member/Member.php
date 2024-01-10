<?php

// Initialise un namespace
namespace Ysthote\Models\Member;

// Récupère le fichier qui contient notre class database
require_once('src/libs/database.php');

use Ysthote\Libs\Database\DatabaseConnection;


class Member
{
    public string $username;
    public string $email;
    public string $idUser;
}

class MemberRepository
{
    public DatabaseConnection $connection;

    public function getMemberInformations(string $idUser): Member
    {
        $statement = $this->connection->getConnection()->prepare('SELECT u.email email, p.username username, p.id_user idUser FROM user_accounts u INNER JOIN profil p ON u.id = p.id_user WHERE u.id = :idUser');
        $statement->execute([
            'idUser' => $idUser,
        ]);
        $row = $statement->fetch();
        $member = new Member();
        $member->email = $row['email'];
        $member->username = $row['username'];
        $member->idUser = $row['idUser'];
        return $member;
    }

    public function theMemberJoinAs(string $choice, int $idUser): bool
    {
        $statement = $this->connection->getConnection()->prepare("UPDATE profil SET joinAs = :joinAs WHERE id_user = :idUser");
        return $statement->execute([
            'joinAs' => $choice,
            'idUser' => $idUser,
        ]);
    }
}