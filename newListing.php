<?php
require 'userSession.php';
require 'pageElements.php';
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Create Vinyl Listing</title>
        <?php writeMetatags('Create a vinyl listing with Music Online'); ?>
        <?php writeCommonStyles(); ?>
        <script src="js\displayError.js"></script>
    </head>
    <?php
    //Diplays an error message if set
    $errMsg = null;
    if (isset($_SESSION['errorMsg'])) {
        $errMsg = $_SESSION['errorMsg'];
        echo "<script> displayError('$errMsg'); </script>";
        unset($_SESSION['errorMsg']);
    }
    ?>
    <body>
        <div id="container">
            <div id="header"><?php displaySignIn(); ?></div>
            <?php displayMenu(NEWLISTING); ?>

            <div id="content" style="overflow: auto;">
                <?php displayCreateListing(); ?>
            </div>
            <?php displayFooter(); ?>
        </div>
    </body>
</html>