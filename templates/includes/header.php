<header class="included-header">
    <div class="logo">
        <h1><a href="index.php">Ysthote</a></h1>
    </div>
    <nav class="included-navbar">
        <ul><?php // If a session is opened, show log out links and other
            if (isset($_SESSION['ID']) || isset($_SESSION['EMAIL'])) {
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