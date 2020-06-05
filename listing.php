<?php
require 'database.php';
require 'pageElements.php';
require 'userSession.php';

unset($_SESSION['errorMsg']);

//Tries to connect to the listings database
if (!connectToDb('listings')) {
    $_SESSION['errorMsg'] = "Sorry, there's an issue with the database";
    header('location:index.php');
    exit();
}

//makes sure the id from get is safe for the database
$id = sanitiseString($_GET['id']);

//Checks if id is lower than 1 and returns user to the index
if (!($id > 0)) {
    $_SESSION['errorMsg'] = "Invalid page selected";
    header('location:index.php');
    exit();
}

//Query that returns data from the selected listing
$sqlQuery = "SELECT * FROM listings WHERE id = '$id'";
$result = $dbConnection->query($sqlQuery);

//if result returns false return to index
if (!$result) {
    closeConnection();
    $_SESSION['errorMsg'] = "Sorry, there's an issue with the database";
    header('location:index.php');
    exit();
}

//sets row to the data returned by the database
$row = $result->fetch_assoc();
closeConnection();

//Gets variables from row variable
$vinylName = $row['vinyl_name'];
$artist = $row['artist'];
$price = $row['price'];
$quantity = $row['quantity'];
$tracklist = $row['tracklist'];
$sellerID = $row['seller_id'];

//Try to connect to the signin database
if (!connectToDb('signin')) {
    $_SESSION['errorMsg'] = "Sorry, there's an issue with the database";
    header('location:index.php');
    exit();
}

//Query to return a username using the seller id
$sqlQuery = "SELECT username FROM users WHERE userid = '$sellerID'";
$result = $dbConnection->query($sqlQuery);
//if result returns false return to index
if (!$result) {
    closeConnection();
    $_SESSION['errorMsg'] = "There was an error with the database";
    header('location:index.php');
    exit();
}

//Saves result to the row variable
$row = $result->fetch_assoc();
closeConnection();

//Gets the username from row and assign it to sellerName
$sellerName = $row['username'];

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title><?php echo $vinylName; ?></title>
    <?php
    writeMetatags("This is the page for $vinylName by $artist");
    writeCommonStyles();
    ?>
</head>
<body>
<?php
//Check for an error message then displays it
$errMsg = null;
if (isset($_SESSION['errorMsg'])) {
    $errMsg = $_SESSION['errorMsg'];
    echo "<script> displayError(\"$errMsg\"); </script>";
    unset($_SESSION['errorMsg']);
}
?>
<div id="container">
    <div id="header">
        <?php displaySignIn(); ?>
    </div>
    <?php displayMenu(LISTING); ?>

    <div id="content" style="overflow: auto;">
        <h1>Details of listing</h1>
        <h2>Vinyl Name: <?php echo $vinylName; ?></h2>
        <h2>Artist: <?php echo $artist; ?></h2>
        <h2>Price: £<?php echo $price; ?></h2>
        <h2>Seller: <?php echo $sellerName; ?></h2>
        <?php

        //Checks if the tracklist isn't empty and replaces spaces with breakline
        if (!($tracklist == null)) {
            ?> <h2>Tracklist: <br><?php echo str_replace(' ', '<br>', $tracklist) ?></h2> <?php
        }

        $username = $_SESSION['userName'];

        //if the user viewing the page is also the seller they get the option to edit or delete their listing
        if ($username == $sellerName) {
        ?>
        <form action="editListing.php" method="post">
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <input type="submit" value="Edit Listing!">
        </form>
        <form action="processDeleteListing.php" method="post">
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <input type="submit" value="Delete Listing!">
        </form>
        <?php
        }
?>
    </div>
</div>
</body>
</html>