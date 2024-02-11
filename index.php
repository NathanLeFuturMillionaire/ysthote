<?php

/**
 * Ceci est le premier fichier à appeller
 * Le site a commencé le 26 Décembre 2023 dans un salon à Nzeng-Ayong
 */

// Includes all the controllers files

use Ysthote\Controllers\Viewing\Views;
use Ysthote\Controllers\Welcome\Welcome;
use Ysthote\Controllers\LoggingOut\Logout;

require_once('src/controllers/Views.php');
require_once('src/controllers/welcome/Welcome.php');
require_once('src/controllers/auth/Logout.php');

require('vendor/autoload.php');

try {
    // This is the rooter, that will call the right controller
    if (isset($_GET['page']) && $_GET['page'] !== '') {
        if ($_GET['page'] === 'home') {
            $homeView = new Views();
            $homeView->homePage();
        } elseif ($_GET['page'] === 'authentication') {
            $enroll = new Views();
            $enroll->enroll();
        } elseif ($_GET['page'] === 'enterConfirmationCode') {
            $enterConfirmationCode = new Views();
            $enterConfirmationCode->displaysTheConfirmationCodePage();
        } elseif ($_GET['page'] === 'confirmed') {
            $accountConfirmedPage = new Views();
            $accountConfirmedPage->displaysSuccessAccountConfirmedPage();
        } elseif ($_GET['page'] === 'login') {
            $loginPage = new Views();
            $loginPage->displaysLoginFormPage();
        } elseif ($_GET['page'] === 'createPassword') {
            // Vérifie si le cookie existe
            if (isset($_COOKIE['ID']) && !empty($_COOKIE['ID'])) {
                $createPasswordPage = new Views();
                $createPasswordPage->displaysCreatePasswordPage();
            } else {
                throw new Exception('Une erreur est survenue car il manque une information que vous avez peut-être supprimée.');
            }
        } elseif ($_GET['page'] === 'welcome') {
            session_start();
            if (isset($_SESSION['ID'])) {
                $displayWelcomePage = new Views();
                $displayWelcomePage->displaysWelcomePage();
            } else {
                header('Location: index.php?page=login');
            }
        } elseif ($_GET['page'] == 'updateJoiningAs') {
            session_start();
            if (isset($_SESSION['ID'])) {
                $updateJoining = new Welcome;
                $updateJoining->setJoiningAs($_POST);
            }
        } elseif ($_GET['page'] == 'photo') {
            session_start();
            if (isset($_SESSION['ID'])) {
                $displayPhotoPage = new Views;
                $displayPhotoPage->displaysPhotoPage();
            } else {
                header('Location: index.php?page=login');
            }
        } elseif($_GET['page'] == 'profil') {
            session_start();
            if(isset($_SESSION['ID'])) {
                $profilPage = new Views;
                $profilPage->displayProfilPage();
            }
        } elseif ($_GET['page'] && $_GET['page'] == 'logout') {
            session_start();
            if (isset($_SESSION['ID'])) {
                $logout = new Logout;
                $logout->logout();
            }
        } else {
            throw new Exception('La page que vous avez demandée n\'existe pas.');
        }
    } else {
        $homeView = new Views();
        $homeView->homePage();
    }
} catch (Exception $e) {
    $errorMessage = $e->getMessage();
    require('templates/error.php');
}
