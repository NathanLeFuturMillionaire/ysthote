<header class="included-header">
    <div class="logo">
        <h1><a href="index.php">Ysthote</a></h1>
    </div>
    <nav class="included-navbar">
        <ul><?php // If a session is opened, show log out links and other
            if (isset($_SESSION['id']) && isset($_SESSION['email'])) {
            } else {
            ?>
                <li><a href="index.php?page=authentication">S'authentifier</a></li>
            <?php
            }
            ?>
        </ul>
    </nav>
</header>