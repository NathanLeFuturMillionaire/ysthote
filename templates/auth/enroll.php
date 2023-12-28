<?php

use Ysthote\Controllers\Auth\Enroll;

session_start(); ?>
<?php $title = 'Ysthote - La plateforme scolaire de calcule de moyennes'; ?>

<?php

require_once('src/controllers/auth/Enroll.php');

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
            <i class="fa fa-user"></i>
            <h2 class="text-left">Créer un compte Ysthote.</h2>
            <p class="text-left">Il est préférable de le créer avec un parent.</p>
        </header>
        <section>
            <form action="" method="post">
                <div class="error-handler">
                <?php
                $enroll = new Enroll();
                $enroll->processesRegistrationFormData($_POST);
                ?>
                </div>
                <label for="email" class="text-left">Addresse email:*</label>
                <input type="text" name="email" id="email" placeholder="Entrez votre addresse email">
                <small style="opacity: 0.9;">Vous recevrez un <strong>code</strong> à cet addresse.</small>
                <button type="submit" name="submit" class="btn btn-darken">Recevoir mon code</button>
                <a href="index.php?page=login" class="have-an-account">J'ai déjà un compte</a>
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