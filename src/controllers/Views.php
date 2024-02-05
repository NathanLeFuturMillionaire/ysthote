<?php

// Init a namespace
namespace Ysthote\Controllers\Viewing;

use Ysthote\Models\Member\MemberRepository;
use Ysthote\Libs\Database\DatabaseConnection;

require_once('src/libs/database.php');


/**
 * Shows all the views pages
 */
class Views
{
    public function homePage()
    {
        require('templates/html/home/home.php');
    }

    public function enroll()
    {
        require('templates/auth/enroll.php');
    }

    public function displaysTheConfirmationCodePage()
    {
        require('templates/auth/confirmationCode.php');
    }

    public function displaysSuccessAccountConfirmedPage()
    {
        require('templates/auth/accountConfirmed.php');
    }

    public function displaysLoginFormPage()
    {
        require('templates/auth/login.php');
    }

    public function displaysCreatePasswordPage()
    {
        require('templates/create/password.php');
    }

    public function displaysWelcomePage()
    {
        require('templates/welcome/welcome.php');
    }

    public function displaysPhotoPage()
    {
        require('templates/welcome/photo.php');
    }

    public function displayProfilPage()
    {
        require('templates/users/profil.php');
    }
}
