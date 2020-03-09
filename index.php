<!DOCTYPE html>
<?php
require 'userSession.php';
require 'pageElements.php';
?>

<html>
    <head>
        <title>Home</title>

        <?php writeMetatags('Home page for RaptorDMG\'\s website'); ?>
        <?php loadCommonStyles(); ?>
    </head>

    <body>
        <div id="container">
            <?php dislayHeader(HOME); ?>
            <?php displayMenu(HOME); ?>

            <div id="content" style="overflow:auto;">
                <h1>Hello, and welcome to my website</h1>
                <p>This is a personal website for my software</p>
            </div>
            <?php displayFooter(); ?>
        </div>
    </body>
</html>
