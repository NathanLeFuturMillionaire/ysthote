<?php

// Initialise un namespace
namespace Ysthote\Controllers\Welcome;

// Utilise les classes venant d'autres fichiers
use Exception;
use Ysthote\Models\MemberRepository;
use Ysthote\Libs\Database\DatabaseConnection;

// Inclue le fichier de chaque namespace, afin de prendre en compte les classes
require_once('src/models/member/Member.php');
require_once('src/libs/database.php');

/**
 * Cette classe contient toutes les méthodes qui ont un trait
 * avec la mise à jour du champs `joinAs` dans la base de données
 */
class Welcome
{
    public function setJoiningAs(array $input)
    {
        $post = $input;
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Si le bouton d'envoi a été cliqué
            if(isset($post['submit'])) {
                // Vérifie si une option a été sélectionnée
                if(
                    (isset($post['choice']) && $post['choice'] == 'pupil') ||
                    (isset($post['choice']) && $post['choice'] == 'parent') ||
                    (isset($post['choice']) && $post['choice']) == 'teacher'
                ) {
                    $choice = strip_tags($post['choice']);
                    // Crée notre instance
                    $member = new MemberRepository;
                    $member->connection = new DatabaseConnection;
                    // Met à jour la table joinAs pour l'adapter en fonction de ce que le membre aurait choisi
                    if($member->theMemberJoinAs($choice, $_SESSION['ID'])) {
                        header('Location: index.php?page=photo');
                    }
                } else {
                    throw new Exception('Les informations attendues ne sont pas celles que vous nous avez envoyées.');
                }
            }
        }
    }
}