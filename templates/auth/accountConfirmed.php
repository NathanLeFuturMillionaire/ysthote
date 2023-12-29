<?php

session_start();

?>
<?php $title = 'Ysthote - Votre compte a été confirmé'; ?>

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
        <img src="pictures/icons/user-faces/user-follow-line.svg" alt="Icone de l'utilisateur" width="50">
            <h2>Compte confirmé</h2>
            <p>Bravo👏! Vous avez confirmé votre compte avec succès, vous pouvez maintenant vous connecter.</p>
        </header>
        <a href="index.php?page=login" name="submit" class="btn btn-darken">Se connecter</a>
    </main>

    <!-- Include the footer page -->
    <?php require('templates/includes/footer.php'); ?>
<?php
}

?>

<?php $content = ob_get_clean(); ?>
<?php require('templates/layout.php'); ?>