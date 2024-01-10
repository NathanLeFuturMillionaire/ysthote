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

    /**
     * Le status du membre
     * @param string $choice Le choix éffectué par le membre
     * @param int $idUser l'ID du membre
     * 
     * @return bool Retourn un booléen
     */
    public function theMemberJoinAs(string $choice, int $idUser): bool
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
     * @param int $idUser L'id du membre qui est sur le point de mettre à jour sa photo
     * 
     * @return bool Retourne un booléen 
     */
    public function updateProfilPicture(string $profilPicture, string $extension, int $idUser): bool
    {
        $statement = $this->connection->getConnection()->prepare("UPDATE profil SET profilPicture = :profilPicture WHERE id_user = :idUser");
        return $statement->execute([
            'profilPicture' => $profilPicture . '.' . $extension,
            'idUser' => $idUser,
        ]);
    }
}