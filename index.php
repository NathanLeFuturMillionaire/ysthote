<?php

// Includes all the controllers files

use Ysthote\Controllers\Viewing\Views;

require_once('src/controllers/Views.php');

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
        } elseif($_GET['page'] === 'confirmed') {
            $accountConfirmedPage = new Views();
            $accountConfirmedPage->displaySuccessAccountConfirmedPage();
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
