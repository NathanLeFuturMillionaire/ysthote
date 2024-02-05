<?php $title = 'Ysthote - Mon profil'; ?>
<?php ob_start(); ?>

<?php require('templates/includes/header.php'); ?>

<h1>Hello world</h1>



<?php $content = ob_get_clean(); ?>
<?php require('templates/layout.php');