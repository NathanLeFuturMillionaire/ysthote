<header class="included-header">
    <div class="logo">
        <?php // If a session is opened, show log out links and other
        if (isset($_SESSION['ID']) || isset($_SESSION['EMAIL'])) {
        ?>
            <h1><a href="index.php?page=profil">Ysthote</a></h1>
        <?php
        } else {
        ?>
            <h1><a href="index.php">Ysthote</a></h1>
        <?php
        }
        ?>

    </div>
    <nav class="included-navbar">
        <ul><?php // If a session is opened, show log out links and other
            if (isset($_SESSION['ID']) || isset($_SESSION['EMAIL'])) {
                ?>
                <form action="" method="post">
                    <!-- <input type="search" name="search" id="search">
                    <input type="submit" value="Rechercher"> -->
                </form>
                <?php
            } else {
            ?>
                <li><a href="index.php?page=authentication">S'inscrire</a></li>
                <li><a href="index.php?page=login">Se connecter</a></li>
            <?php
            }
            ?>
        </ul>
    </nav>
</header>