<?php
ini_set('session.use_strict_mode', 1);
session_start();

require 'database.php';

//Checks user is signed in
if (!isset($_SESSION['userName'])) {
    header('location:index.php');
    exit();
}

unset($_SESSION['errorMsg']);

//connects to listings database
if (!connectToDb('listings')) {
    $_SESSION['errorMsg'] = "Sorry our database isn't feeling well.\nPlease try again later";
    header('location:index.php');
    exit();
}

$username = trim($_SESSION['userName']);
$listingToRemove = trim($_POST['id']);
$listingToRemove = sanitiseString($listingToRemove);
//Query deletes the selected listing
$sqlQuery = "DELETE FROM listings WHERE id = '$listingToRemove' AND seller_id = (SELECT userid FROM signin.users WHERE username = '$username';";
$result = $dbConnection->query($sqlQuery);

//if result false display error message
if (!$result) {
    closeConnection();
    $_SESSION = "Sorry our database isn't feeling well.\nPlease try again later";
}

//close database then return user to index
closeConnection();
header('location:index.php');
