<?php
require 'userSession.php';
require 'pageElements.php';
?>

<!DOCTYPE html>

<html lang="en">
<head>
    <title>Home</title>

    <?php writeMetatags('Music Online is the place to be if your a fan of vinyl music'); ?>
    <?php writeCommonStyles(); ?>
    <script src="js\displayError.js"></script>
</head>

<body>
    <?php
    //Display an error message if set
    $errMsg = null;
    if (isset($_SESSION['errorMsg'])) {
        $errMsg = $_SESSION['errorMsg'];
        echo "<script>displayError(\"$errMsg\"); </script>";
        unset($_SESSION['errorMsg']);
    }
    ?>
<div id="container">
    <div id="header"><?php displaySignIn(); ?></div>
    <?php displayMenu(HOME); ?>

    <div id="content" style="overflow:auto;">
        <h1>Hello, and welcome to MusicOnline</h1>
        <p>This is the place to be if your a fan of vinyl music</p>
    </div><?php displayFooter(); ?>
</div>
</body>
</html>
