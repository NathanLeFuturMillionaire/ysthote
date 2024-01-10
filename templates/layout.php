<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title; ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">    <link href="https://fonts.googleapis.com/css2?family=Manrope&family=Nunito+Sans:opsz@6..12&family=Poppins&family=Roboto&display=swap" rel="stylesheet">
    <?php
    /**
     * Make a switch condition, it will call the right css file
     */
    if(isset($_GET['page']) && $_GET['page'] !== '') {
        $page = strip_tags($_GET['page']);

        switch ($page) {
            case 'home':
                echo '<link rel="stylesheet" href="templates/css/home/home.css">';
            break;
    
            case 'authentication':
                echo '<link rel="stylesheet" href="templates/css/auth/enroll.css">';
            break;

            case 'enterConfirmationCode':
                echo '<link rel="stylesheet" href="templates/css/auth/enterConfirmationCode.css">';
            break;

            case 'confirmed':
                echo '<link rel="stylesheet" href="templates/css/auth/accountConfirmed.css">';
            break;

            case 'enterConfirmationCode':
                echo '<link rel="stylesheet" href="templates/css/auth/enterConfirmationCode.css">';
            break;
            
            case 'login':
                echo '<link rel="stylesheet" href="templates/css/auth/login.css">';
            break;

            case 'createPassword':
                echo '<link rel="stylesheet" href="templates/css/create/password.css">';
            break;

            case 'welcome':
                echo '<link rel="stylesheet" href="templates/css/welcome/welcome.css">';
            break;

            case 'photo':
                echo '<link rel="stylesheet" href="templates/css/welcome/photo.css">';
            break;
        }
    } else {
        echo '<link rel="stylesheet" href="templates/css/home/home.css">';
    }
    ?>
</head>

<body>
    <?= $content; ?>
</body>

</html>