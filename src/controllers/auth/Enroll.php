<?php

// Initialisation d'un espace de noms
namespace Ysthote\Controllers\Auth;

// Importe les classes PHPMailer, Uuids dans l'espace de noms global
use Generator;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use Ysthote\Libs\Database\DatabaseConnection;
use Ysthote\Models\Auth\ConfirmAccountCodeRespository;
use Ysthote\Models\EnrollRepository;

// Charge l'autoload de Composer
// require 'vendor/autoload.php';

require_once('src/libs/database.php');
require_once('src/models/auth/Enroll.php');
require_once('src/models/auth/ConfirmAccount.php');

class Enroll
{
    public function processesRegistrationFormData(array $input)
    {
        $post = $input;
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (isset($post['submit'])) {
                // Vérifie si le champ a été rempli
                if (isset($post['email']) && !empty($post['email'])) {
                    $email = strip_tags($post['email']);
                    if (filter_var($post['email'], FILTER_VALIDATE_EMAIL)) {
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

                            // Crée un code aléatoire
                            $confirmationCode = mt_rand(1000000, 9999999);
                            $enrollRepository = new EnrollRepository();
                            $enrollRepository->connection = new DatabaseConnection();

                            $confirmAccountCodeRepository = new ConfirmAccountCodeRespository();
                            $confirmAccountCodeRepository->connection = new DatabaseConnection();

                            // Vérifie si le compte existe déjà
                            if ($enrollRepository->checksIfUserAlreadyExists($email) == 1) {
                                echo 'Ce compte utilisateur est déjà utilisé.';
                            } else {

                                // Crée le compte
                                $enrollRepository->createAccount($email, $confirmationCode);

                                // Obtient le code de confirmation
                                $getConfirmationCode = $confirmAccountCodeRepository->getConfirmationCode($email);
                                // Contenu
                                $mail->isHTML(true);
                                $mail->Subject = 'Code de confirmation Ysthote';
                                $mail->Body = 'Bonjour ! Votre code de confirmation à 7 chiffres est le ' . $getConfirmationCode->confirmationCode . '.';
                                if ($mail->send()) {
                                    // Crée un cookie
                                    setcookie(
                                        'EMAIL',
                                        $email,
                                        [
                                            'expires' => time() + 365 * 24 * 3600,
                                            'secure' => true,
                                            'httponly' => true,
                                        ],
                                    );
                                    // Redirection vers la page de confirmation
                                    header('Location: index.php?page=enterConfirmationCode');
                                }
                            }
                        } catch (Exception $e) {
                            echo 'Impossible d\'envoyer le message : ' . $mail->ErrorInfo;
                        }
                    } else {
                        echo sprintf('L\'adresse email <strong>%s</strong> n\'est pas valide.', $email);
                    }
                } else {
                    echo 'Veuillez remplir le champ.';
                }
            }
        }
    }
}
