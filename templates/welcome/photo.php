<?php $title = 'Ystthote - Choisissez une photo de profil.'; ?>

<?php ob_start();

use Ysthote\Libs\Database\DatabaseConnection;
use Ysthote\Models\MemberRepository;
use Ysthote\Controllers\Photo\Photo;

require_once 'src/libs/database.php';
require_once 'src/models/member/Member.php';
require_once 'src/controllers/welcome/Photo.php';

$getUserInformation = new MemberRepository;
$getUserInformation->connection = new DatabaseConnection;
$user = $getUserInformation->getMemberInformations($_SESSION['ID']);

// Inclue le header de la page
require('templates/includes/header.php');
?>
<main class="container">
    <header class="profil-picture">
        <h1>Bienvenue <?= strip_tags($user->username); ?></h1>
        <p>Maintenant, choisissez une photo de profil.</p>
        <form action="" method="post" enctype="multipart/form-data">
            <label title="Choisir une photo de profil" for="profil-picture" id="picture"><img src="pictures/icons/user-faces/user-line.svg" alt="Avatar"></label>
            <h1>Profil</h1>
            <input type="file" name="profil-picture" id="profil-picture">
            <p>
                <?php
                    $photo = new Photo;
                    $photo->setPhoto($_POST, $_FILES);
                ?>
            </p>
            <button class="btn btn-darken" name="submit">Terminer</button>
        </form>
    </header>
</main>
<script src="src/js/showImageSelected.js"></script>
<?php $content = ob_get_clean(); ?>
<?php require('templates/layout.php'); ?>