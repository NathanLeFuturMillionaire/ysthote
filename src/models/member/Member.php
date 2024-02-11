<?php

// Initialise un namespace
namespace Ysthote\Models;

// Récupère le fichier qui contient notre class database
require_once('src/libs/database.php');

use Ysthote\Libs\Database\DatabaseConnection;

class Member
{
    public string $username;
    public string $email;
    public string $idUser;
    public string $joinAs;
    public string $profilPicture;
    public string $isSuspended;
    public string $isConfirmed;
}

class MemberRepository
{
    public DatabaseConnection $connection;

    /**
     * Récupère les informations de l'utilisateur
     * 
     * @param string $idUser L'ID de l'utilisateur
     * 
     * @return Member Retourne les propriétés de la classe Member
     * 
     */

    public function getMemberInformations(string $idUser): Member
    {
        $statement = $this->connection->getConnection()->prepare('SELECT u.email email, p.username username, u.is_suspended isSuspended, u.is_confirmed isConfirmed, p.id_user idUser, p.joinAs joinAs, p.profilPicture profilPicture FROM user_accounts u INNER JOIN profil p ON u.id = p.id_user WHERE u.id = :idUser');
        $statement->execute([
            'idUser' => $idUser,
        ]);
        $row = $statement->fetch();
        $member = new Member();
        $member->email = $row['email'];
        $member->username = $row['username'];
        $member->idUser = $row['idUser'];
        $member->joinAs = $row['joinAs'];
        $member->profilPicture = $row['profilPicture'];
        $member->isSuspended = $row['isSuspended'];
        $member->isConfirmed = $row['isConfirmed'];
        return $member;
    }

    /**
     * Le status du membre
     * @param string $choice Le choix éffectué par le membre
     * @param int $idUser l'ID du membre
     * 
     * @return bool Retourn un booléen
     */
    public function theMemberJoinAs(string $choice, string $idUser): bool
    {
        $statement = $this->connection->getConnection()->prepare("UPDATE profil SET joinAs = :joinAs WHERE id_user = :idUser");
        return $statement->execute([
            'joinAs' => $choice,
            'idUser' => $idUser,
        ]);
    }

    /**
     * Mets à jour la photo de profil du membre
     * 
     * @param string profilPicture La photo de profil qui sera ajoutée
     * @param string $idUser L'id du membre qui est sur le point de mettre à jour sa photo
     * @param string $extension l'entension de la photo qui doit être uploadée
     * 
     * @return bool Retourne un booléen 
     */
    public function updateProfilPicture(string $profilPicture, string $extension, string $idUser): bool
    {
        $statement = $this->connection->getConnection()->prepare("UPDATE profil SET profilPicture = :profilPicture WHERE id_user = :idUser");
        return $statement->execute([
            'profilPicture' => $profilPicture . '.' . $extension,
            'idUser' => $idUser,
        ]);
    }

    /**
     * Demande à MySQL si l'utilisateur existe
     */
    public function IsUserExist(string $idUser) : int
    {
        $statement = $this->connection->getConnection()->prepare("SELECT id FROM user_accounts WHERE id = ?");
        $statement->execute([$idUser]);
        return $statement->rowCount();
    }
}