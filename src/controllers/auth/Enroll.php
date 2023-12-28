<?php

// Init a namespace
namespace Ysthote\Controllers\Auth;

//Import PHPMailer, Uuids classes into the global namespace
use Generator;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use Ysthote\Libs\Database\DatabaseConnection;
use Ysthote\Models\Auth\ConfirmAccountCodeRespository;
use Ysthote\Models\EnrollRepository;

//Load Composer's autoloader
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
                // check if the field has been filled
                if (isset($post['email']) && !empty($post['email'])) {
                    $email = strip_tags($post['email']);
                    if (filter_var($post['email'], FILTER_VALIDATE_EMAIL)) {
                        try {
                            $mail = new PHPMailer(true);
                            //Server settings
                            $mail->SMTPDebug = SMTP::DEBUG_SERVER;
                            $mail->isSMTP();
                            $mail->Host       = 'smtp.gmail.com';
                            $mail->SMTPAuth   = true;
                            $mail->Username   = 'misterntkofficiel2.0@gmail.com';
                            $mail->Password   = 'jlkvgxzhbvgvebls';
                            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
                            $mail->Port       = 465;

                            //Recipients
                            $mail->setFrom('misterntkofficiel2.0@gmail.com', 'Ysthote');
                            $mail->addAddress($email);
                            $mail->addReplyTo($email);
                            $mail->addCC($email);
                            $mail->addBCC($email);

                            // Create a random code
                            $confirmationCode = mt_rand(1000000, 9999999);
                            $enrollRepository = new EnrollRepository();
                            $enrollRepository->connection = new DatabaseConnection();

                            $confirmAccountCodeRepository = new ConfirmAccountCodeRespository();
                            $confirmAccountCodeRepository->connection = new DatabaseConnection();

                            // Checks if the account already exists
                            if ($enrollRepository->checksIfUserAlreadyExists($email) == 1) {
                                echo 'Ce compte utilisateur est déjà utilisé.';
                            } else {

                                // Create the account
                                $enrollRepository->createAccount($email, $confirmationCode);

                                // Get the confirmation code
                                $getConfirmationCode = $confirmAccountCodeRepository->getConfirmationCode($email);
                                // Content
                                $mail->isHTML(true);
                                $mail->Subject = 'Code de confirmation Ysthote';
                                $mail->Body = 'Hello ! Votre code de confirmation à 7 chiffres est le ' . $getConfirmationCode->confirmationCode . '.';
                                if ($mail->send()) {
                                    // Create a cookie
                                    setcookie(
                                        'EMAIL',
                                        $email,
                                        [
                                            'expires' => time() + 365 * 24 * 3600,
                                            'secure' => true,
                                            'httponly' => true,
                                        ],
                                    );
                                    // Now redirect to the confirmation page
                                    header('Location: index.php?page=enterConfirmationCode');
                                }
                            }
                        } catch (Exception $e) {
                            echo 'Impossible d\'envoyer le message : ' . $mail->ErrorInfo;
                        }
                    } else {
                        echo sprintf('L\'addresse email <strong>%s</strong> n\'est pas valide.', $email);
                    }
                } else {
                    echo 'Veuillez remplir le champs.';
                }
            }
        }
    }
}
