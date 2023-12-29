<?php

use Ysthote\Controllers\Auth\Enroll;
use Ysthote\Controllers\Auth\TakesCareofConnectionData;

session_start(); ?>
<?php $title = 'Ysthote - Connexion'; ?>

<?php

require_once('src/controllers/auth/Login.php');

?>

<?php ob_start(); ?>

<?php
// Check if there's a session opened
if (isset($_SESSION['id']) && isset($_SESSION['email'])) {
    // Redirect to the session home page
} else {
    // Include the header file
    require('templates/includes/header.php');
?>
    <main class="container">
        <header>
            <!-- <i class="fa fa-user"></i> -->
            <img src="pictures/icons/user-faces/user-3-fill.svg" alt="Icone de l'utilisateur" width="50">
            <h2 class="text-left">Se connecter</h2>
            <p class="text-left">Connectez-vous à votre compte</p>
        </header>
        <section>
            <form action="" method="post">
                <div class="error-handler">
                <?php
                $login = new TakesCareofConnectionData();
                ?>
                </div>
                <label for="email" class="text-left">Addresse email:*</label>
                <input type="text" name="email" id="email" placeholder="Entrez votre addresse email">
                <small style="opacity: 0.9;">L'addresse avec laquelle vous vous êtes inscrit(e).</small>
                <button type="submit" name="submit" class="btn btn-darken">Connexion</button>
                <a href="index.php?page=authentication" class="have-an-account">Je n'ai pas de compte</a>
            </form>
        </section>
    </main>

    <!-- Include the footer page -->
    <?php require('templates/includes/footer.php'); ?>
<?php
}

?>

<?php $content = ob_get_clean(); ?>
<?php require('templates/layout.php'); ?>