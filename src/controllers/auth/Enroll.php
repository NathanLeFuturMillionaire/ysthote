<?php

// Init a namespace
namespace Ysthote\Controllers\Auth;

//Import PHPMailer classes into the global namespace
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';

require_once('src/libs/database.php');

use Ysthote\Libs\Database\DatabaseConnection;

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
                        $mail->addReplyTo('misterntkofficiel2.0@gmail.com');
                        $mail->addCC('misterntkofficiel2.0@gmail.com');
                        $mail->addBCC('misterntkofficiel2.0@gmail.com');

                        // Content
                        $mail->isHTML(true);
                        $mail->Subject = 'Code de vérification Ysthote';
                        $mail->Body = 'Voici votre code de vérification Yshote:';
                        $mail->AltBody = 'Bon là je pense que je n\'ai rien à te dire.';

                        if($mail->send()) {
                            echo sprintf('Un code de confirmation a été envoyé à <strong>%s</strong>, consultez votre boîte mail.', $email);
                        }
                        } catch(Exception $e) {
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
