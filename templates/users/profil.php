<?php $title = 'Ysthote - Mon profil'; ?>
<?php ob_start(); ?>

<?php

use Ysthote\Libs\Database\DatabaseConnection;
use Ysthote\Models\MemberRepository;

require_once('src/models/member/Member.php');
require_once('src/libs/database.php');

$memberRepository = new MemberRepository;
$memberRepository->connection = new DatabaseConnection;
$member = $memberRepository->getMemberInformations($_SESSION['ID']);
$id_user = $_SESSION['ID'];

/**
 * Cette condition vérifie si l'utilisateur existe en suivant les critères suivants:
 *  - Si l'utiliseur existe
 *  - Si le compte utilisateur n'est pas suspendu
 *  - Si le compte utilisateur est confirmé
 */
if ($memberRepository->IsUserExist($id_user) == 1) {
    if ($member->isSuspended == 0) {
        if ($member->isConfirmed == 1) {
?>
            <div id="main-page">
                <?php
                // Insère le header
                require('templates/includes/header.php');
                ?>
                <header>
                    <div class="user-photo-and-username">
                        <div class="photo">
                            <?php if($member->profilPicture != 'no'): ?>
                                <img src="templates/users/profil-picture/<?= $member->profilPicture; ?>" alt="Photo de profil de l'utilisateur" width="80" height="80">
                            <?php else: ?>
                                <img src="pictures/icons/user-faces/user-3-fill.svg" alt="Avatar" width="80" height="80">
                            <?php endif; ?>
                        </div>
                    </div>
                </header>
            </div>
<?php

        } else {
            throw new Exception('Votre compte Ysthote n\'a pas été confirmé.');
        }
    } else {
        throw new Exception('Votre compte Ysthote a été suspendu.');
    }
} else {
    throw new Exception('Ce membre n\'existe pas, ou tout du moins, n\'existe plus.');
}




?>



<?php $content = ob_get_clean(); ?>
<?php require('templates/layout.php');
