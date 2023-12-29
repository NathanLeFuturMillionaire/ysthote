<?php

// Initialise un espace de noms
namespace Ysthote\Controllers\Auth;

// Utilise les classes de l'espace de noms

use Exception;
use Ysthote\Libs\Database\DatabaseConnection;
use Ysthote\Models\Auth\ConfirmAccountCode;
use Ysthote\Models\Auth\ConfirmAccountCodeRespository;

require_once('src/models/auth/Enroll.php');
require_once('src/libs/database.php');

class ConfirmAccount
{
    public function ProcessesTheDataComingFromTheCodeConfirmationForm(array $input)
    {
        $post = $input;

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (isset($post['submit'])) {
                // Vérifie si le champ du code de confirmation est correctement rempli
                if (isset($post['confirmationCode']) && !empty($post['confirmationCode'])) {
                    $confirmationCode = strip_tags($post['confirmationCode']);
                    if (strlen($confirmationCode) <= 7) {
                        // Instancie des classes de dépôt d'enregistrement
                        $confirmAccountCodeRepository = new ConfirmAccountCodeRespository();
                        $confirmAccountCodeRepository->connection = new DatabaseConnection();
                        // Récupère le code de confirmation stocké dans la base de données
                        if(isset($_COOKIE['EMAIL'])) {
                            $getConfirmationCodeStoredInTheDatabase = $confirmAccountCodeRepository->getConfirmationCode($_COOKIE['EMAIL']);
                            // Compare le vrai code à celui saisi dans le formulaire
                            if ($getConfirmationCodeStoredInTheDatabase->confirmationCode === $confirmationCode) {
                                // Maintenant, nous pouvons confirmer le compte
                                if($confirmAccountCodeRepository->confirmAccount($_COOKIE['EMAIL'])) {
                                    header('Location: index.php?page=confirmed');
                                } else {
                                    throw new Exception('Impossible de confirmer votre compte, veuillez réessayer.');
                                }
                            } else {
                                echo 'Code de confirmation incorrect.';
                            }

                        } else {
                            throw new Exception('Impossible de récupérer le code de confirmation car vous avez probablement supprimé le cookie qui le contenait.');
                        }
                    } else {
                        echo 'Code de confirmation incorrect.';
                    }
                } else {
                    echo 'Veuillez saisir votre code de confirmation.';
                }
            }
        }
    }
}
