<?php

// Initialise un namespace
namespace Ysthote\Controllers\Create;

require_once('src/Models/create/Password.php');
require_once('src/libs/database.php');

use Ysthote\Libs\Database\DatabaseConnection;
use Ysthote\Models\Create\CreatePasswordRepository;

class SetUsernameAndPassword
{
    public function ProcessesTheDataComingFromTheCompletionForm(array $input)
    {
        $post = $input;
        if($_SERVER['REQUEST_METHOD'] == 'POST')
        {
            // Si le bouton d'envoi a été cliqué
            if(isset($post['submit']))
            {
                // Vérifie les informations du formulaire
                if(!isset($post['username']) || empty($post['username']) || !isset($post['password']) || empty($post['password']) || !isset($post['confirm-password']) || empty($post['confirm-password'])) {
                    echo 'Veuillez remplir tous les champs.';
                } else {
                    $username = strip_tags($post['username']);
                    $password = htmlspecialchars($post['password']);
                    $confirmPassword = htmlspecialchars($post['confirm-password']);

                    if(strlen($username) >= 2) {
                        // Vérifie si le nom commence par une lettre majuscule
                        if(preg_match('/^[A-Z][a-z]*(?:\s[A-Z][a-z]*)*$/', $username)) {
                            // Vérifie la validité du mot de passe
                            if(preg_match('/^(?=.*[@%$*^])(?=.*[a-zA-Z])(?=.*[0-9]).{6,}$/', $password)) {
                                // Vérifie que le premier mot de passe est bien égale au second
                                if($password === $confirmPassword) {
                                    // Hash le mot de passe
                                    $password_hash = password_hash($$password, PASSWORD_DEFAULT);
                                    // Update User Password
                                    $passwordRepository = new CreatePasswordRepository();
                                    $passwordRepository->connection = new DatabaseConnection();
                                    $updateUserInformation = $passwordRepository->UpdatesUserInformation($username, $password_hash, $_COOKIE['ID']);
                                    if($updateUserInformation) {
                                        // Si le nom et le mot de passe a été défini, on rédirige vers ma page de bienvenue
                                        // Et on ouvre une session
                                        session_start();
                                        $_SESSION['ID'] = $_COOKIE['ID'];
                                        header('Location: index.php?page=welcome');
                                    }
                                } else {
                                    echo 'Vos mots de passes ne correspondent pas.';
                                }
                            } else {
                                echo 'Votre mot de passe doit contenir des chiffres et des lettres et au moins un symbol.';
                            }
                        } else {
                            echo 'Un nom ou prénom doit commencer par une lettre majuscule.';
                        }
                    } else {
                        echo 'Votre nom d\'utilisateur doit composer plus de 2 caractère.';
                    }
                }
            }
        }
    }
}