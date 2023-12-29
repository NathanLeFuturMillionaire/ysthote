<?php

session_start(); ?>
<?php $title = 'Ysthote - Créez un mot de passe'; ?>

<?php

require_once('src/controllers/create/Password.php');
require_once('src/models/create/Password.php');

use Ysthote\Controllers\Create\SetUsernameAndPassword;

?>

<?php ob_start(); ?>

<?php
// Check if there's a session opened
if (isset($_SESSION['id']) || isset($_SESSION['email'])) {
    // Redirect to the session home page
} else {
    // Include the header file
    require('templates/includes/header.php');

?>
    <main class="container">
        <header>
            <!-- <i class="fa fa-user"></i> -->
            <img src="pictures/icons/system/lock-fill.svg" alt="Icone de l'utilisateur" width="50">
            <h2>Vous n'êtes pas encore connecté(e)</h2>
            <p>Créez un mot de passe afin de finaliser votre connexion.</p>
        </header>
        <section>
            <form action="" method="post">
                <div class="error-handler">
                <?php
                $setUsernameAndPasswordRepository = new SetUsernameAndPassword();
                $setUsernameAndPasswordRepository->ProcessesTheDataComingFromTheCompletionForm($_POST);
                ?>
                </div>
                <label for="username" class="text-left">Nom d'utilisateur:*</label>
                <input value="<?php if(isset($_POST['username'])) {echo strip_tags($_POST['username']);} ?>" type="text" name="username" id="username" placeholder="Nom d'utilisateur">
                <small style="opacity: 0.9;">Nous vous conseillons de mettre votre <strong>nom de famille</strong>.</small>
                
                <label for="password" class="text-left">Mot de passe:*</label>
                <input type="password" name="password" id="password" placeholder="Entrez votre mot de passe">
                <small style="opacity: 0.9;">Plus de 6 caractères, des chiffres et des lettres et un des symbols : <strong>@,$,%,^,*</strong></small>

                <label for="confirm-password">Confirmez le mot de passe:*</label>
                <input type="password" name="confirm-password" id="confirm-password" placeholder="Confirmez le mot de passe">

                <button type="submit" name="submit" class="btn btn-darken">Terminer</button>
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