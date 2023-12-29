<?php

// Initialise un namespace
namespace Ysthote\Controllers\Auth;

// Utilise les namespaces global
use Ysthote\Libs\Database\DatabaseConnection;
use Ysthote\Models\Auth\LoginRepository;

// inclue le fichier du Login class
require_once('src/models/auth/Login.php'); 

class TakesCareofConnectionData
{
    /**
     * Valide les informations issues du formulaire de connexion
     * @param string $email L'addresse email qui doit être fournie pour valider la connexion
     */
    public function ValidateLoginForm(string $email)
    {
        
    }
}