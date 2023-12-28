<?php

// Includes all the controllers files

use Ysthote\Controllers\Viewing\Views;

require_once('src/controllers/Views.php');

require('vendor/autoload.php');

// This is the rooter, that will call the right controller
if(isset($_GET['page']) && $_GET['page'] !== '') {
    if($_GET['page'] === 'home') {
        $homeView = new Views();
        $homeView->homePage();
    } elseif($_GET['page'] === 'authentication') {
        $enroll = new Views();
        $enroll->enroll();
    }
} else {
    $homeView = new Views();
    $homeView->homePage();
}