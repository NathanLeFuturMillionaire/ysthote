<?php $title = 'Ysthote - Une erreur s\'est produite'; ?>

<?php

ob_start();

?>

<main class="error-message">
    <header>Une erreur s'est produite</header>
    <p><?= $errorMessage; ?></p>

    <?php
        if(isset($_SESSION['ID'])) {
            echo '<a href="index.php?page=logout">Se déconnecter</a>';
        }
    ?>
</main>

<?php $content = ob_get_clean(); ?>
<?php require('templates/layout.php'); ?>