<?php
    require 'userSession.php';
    require 'pageElements.php';
    require 'database.php';

    //Checks user to edit is set and returns user to index if not
    if (!isset($_POST['username'])) {
        header("location: processSignOut.php");
        exit();
    }

    //Checks the posted username is valid and signs user out if not
    $localUser = trim($_POST['username']);
    if (!preg_match('/[A-Za-z0-9]/', $localUser)) {
        header("location: processSignOut.php");
        exit();
    }

    ?>

<html>
    <head>
        <title>Edit User</title>
        <?php writeCommonStyles(); ?>
        <script src="js\validateForm.js"></script>
        <script src="js\displayError.js"></script>
    </head>
    <body>
        <div id="container">
            <div id="header"><?php displaySignIn(); ?><h1>Edit Details</h1></div>

            <?php displayMenu(ADMIN); ?>

            <div id="content" style="overflow: auto;">
                <h1>Edit User Details</h1>

                <?php
                    //Tries to connect to the signin database
                    if (!connectToDb('signin')) {
                        echo "<script> displayErrorDatabase(); </script>";
                    } else {
                        //Query to return the results of the user being edited
                        $sqlQuery = "SELECT * FROM Users WHERE UserName='$localUser'";
                        $result = $dbConnection->query($sqlQuery);

                        //If the database doesn't return one row display error
                        if ($result->num_rows != 1) {
                            closeConnection();
                            echo "<script>displayErrorDatabase();</script>";
                        }

                        //Gets fields from the database and send them to displayAdminForm function
                        else {
                            $row = $result->fetch_assoc();
                            $name = $row['Name'];
                            $email = $row['Email'];
                            $admin = $row['Admin'];
                            closeConnection();

                            displayAdminForm($name, $email, $localUser, $admin);
                        }
                    }
                    ?>
            </div>
            <?php displayFooter(); ?>
        </div>
    </body>
</html>