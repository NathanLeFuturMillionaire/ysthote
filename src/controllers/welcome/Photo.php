<?php

// Initialise un namespace
namespace Ysthote\Controllers\Photo;

// Utilise les classes venant d'autres fichiers
use Ysthote\Models\Member\MemberRepository;
use Ysthote\Libs\Database\DatabaseConnection;
use Gumlet\ImageResize;

class Photo
{
    public function setPhoto(array $input, array $file)
    {
        $post = $input;
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            if(isset($post['submit']))
            {
                if(isset($file['profil-picture']) && $file['profil-picture']['error'] == 0) {
                    if($file['profil-picture']['size'] <= 2000000) {
                        $fileInfo = pathinfo($file['profil-picture']['name']);
                        $extension = $fileInfo['extension'];
                        $allowedExtension = ['jpeg', 'jpg', 'png', 'gif'];
                        if(in_array($extension, $allowedExtension)) {
                            move_uploaded_file($file['profil-picture']['tmp_name'], 'templates/users/profil-picture/' . $_SESSION['ID'] . '.' . $extension);
                            echo 'Importée';
                        } else {
                            echo 'Seuls les images .jpeg, .jpg, .png, .gif sont autorisées.';
                        }
                    } else {
                        echo 'La taille de votre image est trop grande.';
                    }
                } else {
                    echo 'Une erreur s\'est produite.';
                }
            }
        }
    }
}