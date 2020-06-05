<?php
require 'userSession.php';
require 'pageElements.php';
require 'database.php';

//If there's no id set in post return to the index page
if (!isset($_POST['id'])) {
    header("location:index.php");
    exit();
}
?>
<html lang="en">
<head>
    <title>Edit Listing</title>
    <?php writeCommonStyles();?>
    <script src="js\displayError.js"></script>
</head>
<body>
<div id="container">
    <div id="header"><?php displaySignIn()?></div>
    <?php displayMenu(LISTING)?>

    <div id="content" style="overflow: auto;">
        <h1>Edit your listing:</h1>
        <?php
        //Try to connect to the listings database
        if (!connectToDb('listings')) {
            echo "<script>displayErrorDatabase();</script>";
        }

        //Gets data from a listing to allow a user to edit it
        else {
            $id = trim($_POST['id']);
            $id = sanitiseString($id);
            $username = trim($_SESSION['userName']);
            $username = sanitiseString($username);

            //Query gets all data from the database where the id is selected and the user is the one selling the item
            $sqlQuery = "SELECT * FROM listings WHERE id = '$id' AND seller_id = (SELECT userid FROM signin.users WHERE username = '$username');";
            $result = $dbConnection->query($sqlQuery);
            if (!$result) {
                echo "<script>displayErrorDatabase();</script>";
            }

            //Gets details from the database result
            else {
                $row = $result->fetch_assoc();
                $vinylName = $row['vinyl_name'];
                $artist = $row['artist'];
                $price = $row['price'];
                $quantity = $row['quantity'];
                $trackList = $row['tracklist'];

                //Displays the modify listing form and assigns variables obtained from the database result
                displayModifyListing("processUpdateListing.php", "modifyListing", "$vinylName", "$artist", "$price", "$quantity", "$trackList", "$id");
            }
        }
        ?>
    </div>
</div>
</body>
</html>
