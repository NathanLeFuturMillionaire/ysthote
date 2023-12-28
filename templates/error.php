<?php $title = 'Ysthote - Une erreur s\'est produite'; ?>

<?php ob_start(); ?>

<main class="error-message">
    <header>Une erreur s'est produite</header>
    <p><?= $errorMessage; ?></p>
</main>

<?php $content = ob_get_clean(); ?>
<?php require('templates/layout.php'); ?>