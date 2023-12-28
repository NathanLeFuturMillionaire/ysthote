<?php

// Init a namespace
namespace Ysthote\Controllers\Auth;

// Use namespace classes

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
                // Check if the confirmation code field is properly filled
                if (isset($post['confirmationCode']) && !empty($post['confirmationCode'])) {
                    $confirmationCode = strip_tags($post['confirmationCode']);
                    if (strlen($confirmationCode) <= 7) {
                        // Instance enroll repository classes
                        $confirmAccountCodeRepository = new ConfirmAccountCodeRespository();
                        $confirmAccountCodeRepository->connection = new DatabaseConnection();
                        // Get the confirmation code stored in the database
                        if(isset($_COOKIE['EMAIL'])) {
                            $getConfirmationCodeStoredInTheDatabase = $confirmAccountCodeRepository->getConfirmationCode($_COOKIE['EMAIL']);
                            // Compare the true code to the one entered in the form
                            if ($getConfirmationCodeStoredInTheDatabase->confirmationCode === $confirmationCode) {
                                // Now we can confirm the account
                                if($confirmAccountCodeRepository->confirmAccount($_COOKIE['EMAIL'])) {
                                    header('Location: index.php?page=confirmed');
                                } else {
                                    throw new Exception('Impossible de confirmer votre compte, veuillez ré-essayer.');
                                }
                            } else {
                                echo 'Code de confirmation incorrecte.';
                            }

                        } else {
                            throw new Exception('Impossible de récupérer le code de confirmation car vous avez surrément supprimé le cookie qui le detenait.');
                        }
                    } else {
                        echo 'Code de confirmation incorrecte.';
                    }
                } else {
                    echo 'Veuillez saisir votre code de confirmation.';
                }
            }
        }
    }
}
