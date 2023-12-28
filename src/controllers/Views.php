<?php

// Init a namespace
namespace Ysthote\Controllers\Viewing;

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
}