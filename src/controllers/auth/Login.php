<?php

// Initialise un namespace
namespace Ysthote\Controllers\Auth;

// Utilise les namespaces global

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use Ysthote\Libs\Database\DatabaseConnection;
use Ysthote\Models\Auth\ConfirmAccountCodeRespository;
use Ysthote\Models\Auth\LoginRepository;

// inclue le fichier du Login class
require_once('src/models/auth/Login.php');
require_once('src/models/auth/ConfirmAccount.php');

class TakesCareofConnectionData
{
    /**
     * Valide les informations issues du formulaire de connexion
     * @param string $email L'addresse email qui doit être fournie pour valider la connexion
     * @param array $input le tableau associatif qui recoit les données du formulaire
     */
    public function ValidateLoginForm(array $input)
    {
        $post = $input;
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Si le bouton d'envoi a été cliqué
            if (isset($post['submit'])) {
                // Traite les données du formulaire de connexion
                if (isset($post['email']) && !empty($post['email'])) {
                    $email = strip_tags($post['email']);
                    if (filter_var($post['email'], FILTER_VALIDATE_EMAIL)) {
                        // Vérifie si l'adresse email existe
                        $loginRepository = new LoginRepository();
                        $loginRepository->connection = new DatabaseConnection();
                        if ($loginRepository->ChecksIfEmailAddressEntryExists($email) == 1) {
                            // On récupère d'abord l'ID de l'utilisateur
                            $getUserId = $loginRepository->getUserID($email);
                            /**
                             * vérifie toute première si la personne qui essaie de se connecter
                             * a déjà rempli ses informations de profil
                             */
                            if ($loginRepository->ChecksIfThePersonTryingToConnectHasAlreadyFilledoutTheirProfile($email) == 1) {
                                // Vérifie le champs "pass", pour voir si l'utilisateur a déjà défini un mot de passe
                                /**
                                 * Si l'utilisateur n'a pas défini son mot de passe, alors on le redirige
                                 * vers cette page qui demande de créer un nouveau mot de passe avant d'aller
                                 * plus loin
                                 */
                                $getPassword = $loginRepository->GetPasswordColumn($getUserId->userId);
                                if ($getPassword->password != 'no') {
                                    // L'utilisateur a déjà défini un mot de passe
                                    // Vérifie si le compte est confirmé
                                    if ($loginRepository->GetPasswordColumn($getUserId->userId)->isConfirmed == 1) {
                                    } else {
                                        /**
                                         * Le compte utlisateur n'est pas confirmé, alors on envois
                                         * un code de confirmation
                                         */
                                        $confirmAccountCodeRepository = new ConfirmAccountCodeRespository();
                                        $confirmAccountCodeRepository->connection = new DatabaseConnection();
                                        try {
                                            $mail = new PHPMailer(true);
                                            // Paramètres du serveur
                                            $mail->SMTPDebug = SMTP::DEBUG_SERVER;
                                            $mail->isSMTP();
                                            $mail->Host       = 'smtp.gmail.com';
                                            $mail->SMTPAuth   = true;
                                            $mail->Username   = 'misterntkofficiel2.0@gmail.com';
                                            $mail->Password   = 'jlkvgxzhbvgvebls';
                                            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
                                            $mail->Port       = 465;
    
                                            // Destinataires
                                            $mail->setFrom('misterntkofficiel2.0@gmail.com', 'Ysthote');
                                            $mail->addAddress($email);
                                            $mail->addReplyTo($email);
                                            $mail->addCC($email);
                                            $mail->addBCC($email);
    
                                            $getConfirmationCode = $confirmAccountCodeRepository->getConfirmationCode($email);
                                            // Contenu
                                            $mail->isHTML(true);
                                            $mail->Subject = 'Code de confirmation Ysthote';
                                            $mail->Body = 'Bonjour ! Votre code de confirmation à 7 chiffres est le ' . $getConfirmationCode->confirmationCode . '.';
    
                                            // Si le code a bien été envoyé avec succès
                                            if($mail->send()) {
                                                // Rediriger vers la page de confirmation du code
                                                header('Location: index.php?page=enterConfirmationCode&motif=unConfirmed');
                                            }
                                        } catch(Exception $e) {
                                            echo 'Impossible d\'envoyer le message : ' . $mail->ErrorInfo;
                                        }
                                    }
                                } else {
                                    /**
                                     * Vérifie d'abord si le compte est confirmé avant d'afficher la page
                                     * qui demande la création de mot de passe
                                     */
                                    if ($getPassword->isConfirmed == 1) {
                                        /**
                                         * Ecrase le cookie existant pour utiliser le nouveau
                                         */
                                        setcookie(
                                            'ID',
                                            $getUserId->userId,
                                            [
                                                'expires' => time() + 365 * 24 * 3600,
                                                'secure' => true,
                                                'httponly' => true,
                                            ],
                                        );
                                        header('Location: index.php?page=createPassword');
                                    } else {
                                        echo sprintf('Impossible de continuer car l\'adresse <strong>%s</strong> n\'a pas encore été confirmé.', $getPassword->email);
                                    }
                                }
                            } else {
                                /**
                                 * S'il n'a pas encore rempli, on crée un cookie qui va sauvegarder son ID
                                 * Ensuite on ajoute ses informations en base de données puis on redirige vers
                                 * la page de définition de mot de passe
                                 */
                                setcookie(
                                    'ID',
                                    $getUserId->userId,
                                    [
                                        'expires' => time() + 365 * 24 * 3600,
                                        'secure' => true,
                                        'httponly' => true,
                                    ],
                                );
                                if ($loginRepository->AddUserInformationInProfile($getUserId->userId)) {
                                    header('Location: index.php?page=createPassword');
                                }
                            }
                        } else {
                            echo 'Addresse email incorrecte';
                        }
                    } else {
                        echo sprintf('L\'addresse email <strong>%s</strong> n\'est pas valide.', $email);
                    }
                } else {
                    echo 'Veuillez entrer votre addresse email.';
                }
            }
        }
    }
}
