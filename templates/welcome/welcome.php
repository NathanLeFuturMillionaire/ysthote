<?php $title = 'Ysthote - Bienvenue sur Ysthote !'; ?>

<?php
ob_start();

use Ysthote\Libs\Database\DatabaseConnection;
use Ysthote\Models\Member\MemberRepository;

require_once 'src/libs/database.php';
require_once 'src/models/member/Member.php';

$getUserInformation = new MemberRepository;
$getUserInformation->connection = new DatabaseConnection;
$user = $getUserInformation->getMemberInformations($_SESSION['ID']);

// Inclue le header de la page
require('templates/includes/header.php');

?>

<main class="container">
    <header>
        <h1>Bienvenue <?= strip_tags($user->username); ?> !</h1>
        <p>Commencez par nous dire quel est le lien qui semble être le mieux pour vous.</p>
    </header>
    <form action="index.php?page=updateJoiningAs" method="post">
        <div class="flex-content">
            <div class="card">
                <input type="radio" name="choice" id="pupil" value="pupil" />
                <fieldset>
                    <label for="pupil"><img src="pictures/icons/others/graduation-cap-fill.svg" alt="Image d'un élève">
                        <h3>Élève</h3>
                        En tant que tel, vous avez la possibilité d'entrer vos notes, les coéfficients de chacun d'elles,
                        de les enregistrer, de calculer votre moyenne et bien plus encore.
                    </label>
                </fieldset>
            </div>
            <div class="card">
                <input type="radio" name="choice" id="parent" value="parent" />
                <fieldset>
                    <label for="parent"><img src="pictures/icons/user-faces/women-line.svg" alt="Icon d'une femme">
                        <h3>Parent d'élève</h3>
                        En tant que tel, vous avez la possibilité de voir les notes enregistrées par chaque élève,
                        de les évaluer en donnant des avis et des appréciations.
                    </label>
                </fieldset>
            </div>
            <div class="card">
                <input type="radio" name="choice" id="teacher" value="teacher" />
                <fieldset>
                    <label for="teacher"><img src="pictures/icons/business/presentation-fill.svg" alt="Enseignant">
                        <h3>Enseignant</h3>
                        En tant que tel, vous avez tous les droits qu'un enseignant pourrait avoir,
                        vous serez en possibilité de donner des cours et bien plus encore.
                    </label>
                </fieldset>
            </div>
        </div>
        <!-- <li><input type="radio" name="choice" value="pupil" id="pupil" /><label for="pupil"><img src="pictures/icons/others/graduation-cap-line.svg" /></label></li>
        <li><input type="radio" name="choice" value="parent" id="parent" /><label for="parent"><img src="pictures/icons/user-faces/women-line.svg" /></label></li>
        <li><input type="radio" name="choice" value="teacher" id="teacher" /><label for="teacher"><img src="pictures/icons/business/presentation-fill.svg" /></label></li> -->
        <div class="button">
            <button type="submit" class="btn btn-darken" name="submit">Suivant</button>
        </div>
    </form>
</main>
<?php require('templates/includes/footer.php'); ?>
<?php $content = ob_get_clean(); ?>
<?php require 'templates/layout.php'; ?>