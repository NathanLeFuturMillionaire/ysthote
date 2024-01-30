<?php

session_start();

use Ysthote\Controllers\Auth\Enroll;
use Ysthote\Controllers\Auth\ConfirmAccount;

 ?>
<?php $title = 'Ysthote - Code de confirmation'; ?>

<?php

require_once('src/controllers/auth/Enroll.php');
require_once('src/controllers/auth/ConfirmAccount.php');
// Comment here!

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
            <img src="pictures/icons/user-faces/user-3-line.svg" alt="Icone de l'utilisateur" width="50">
            <h2>
                <?php if(isset($_GET['motif']) && $_GET['motif'] != ''): ?>
                    Votre compte semble être non confirmé
                <?php else: ?>
                    Confirmez votre compte
                <?php endif; ?>
            </h2>
            <?php if (isset($_COOKIE['EMAIL'])) : ?>
                <p>
                    Entrez le code envoyé à l'addresse <strong><?= strip_tags($_COOKIE['EMAIL']); ?></strong>.
                </p>
            <?php else : ?>
                <p>Nous avons envoyé un code de confirmation à 7 chiffre à l'addresse email
                    que vous avez saisi lors de l'inscription, veuillez consultez votre boîte mail.
                </p>
            <?php endif; ?>
        </header>
        <section>
            <form action="" method="post">
                <div class="error-handler">
                    <?php
                    $confirmAccount = new ConfirmAccount();
                    $confirmAccount->ProcessesTheDataComingFromTheCodeConfirmationForm($_POST);
                    ?>
                </div>
                <label for="confirmationCode" class="text-left">Code de confirmation:*</label>
                <input type="text" maxlength="7" name="confirmationCode" id="confirmationCode" placeholder="Entrez votre addresse email">
                <button type="submit" name="submit" class="btn btn-darken">Confirmer mon compte</button>
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