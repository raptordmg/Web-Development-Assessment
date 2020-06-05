<?php
require 'userSession.php';
require 'pageElements.php';?>

<!DOCTYPE html>

<html lang="en">
	<head>
		<title>Register</title>
        <?php writeCommonStyles();?>
        <script src="js\displayError.js"></script>
	</head>
	<body>
		<div id="container">
            <div id="header"> <?php displaySignIn(); ?></div>
                  <?php displayMenu(REGISTER);?>


            <div id="content" style="overflow: auto">
			    <h1>New User Registration</h1>
		
			    <p>Please enter the following details to complete your registration...</p>

            <?php
            //Displays an error message
            if (isset($_SESSION['errorMsg'])) {
                $errorMsg = $_SESSION['errorMsg'];
                echo "<script>displayError(\"$errMsg\"); </script>";
                unset($_SESSION['errorMsg']);
            }
            ?>

			<?php displayRegForm(); ?>
        </div>
            <?php displayFooter(); ?>
        </div>

	</body>
</html>