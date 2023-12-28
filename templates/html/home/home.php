<?php session_start(); ?>
<?php $title = 'Ysthote - La plateforme scolaire de calcule de moyennes'; ?>

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
            <h2>Ysthote</h2>
            <p>La plateforme scolaire spécialisée dans le calcul de moyennes.</p>
        </header>
        <section>
            <a href="index.php?page=authentication" class="btn btn-darken" title="Authentifiez-vous dès maintenant">S'authentifier</a>
        </section>
    </main>

    <!-- Include the footer page -->
    <?php require('templates/includes/footer.php'); ?>
<?php
}

?>

<?php $content = ob_get_clean(); ?>
<?php require('templates/layout.php'); ?>