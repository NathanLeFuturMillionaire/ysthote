<?php

namespace Ysthote\Controllers\LoggingOut;


class Logout
{
    public function logout()
    {
        // Vérifie si une session existe déjà
        if(isset($_SESSION['ID'])) {
            // Mets fin à la session et redirige vers la page de connexion
            session_destroy();
            header('Location: index.php?page=login');
        }
    }
}
