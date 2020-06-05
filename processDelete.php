<?php
ini_set('session.use_strict_mode', 1);
session_start();

require 'database.php';

//If username isn't set in session return to index page
if (!isset($_SESSION['userName'])) {
    header('location:index.php');
    exit();
}

$username = $_SESSION['userName'];
$admin = $_SESSION['adminLevel'];

//If user isn't an admin sign them out
if ($admin < 1) {
    header('location:processSignOut.php');
    exit();
}

//Unset the error message
unset($_SESSION['errorMsg']);

//checks username is set in post data
if (!isset($_POST['username'])) {
    header('location:index.php');
    exit();
}

$selectedusername = trim($_POST['username']);

//connects to the signin database
if (!connectToDb('signin')) {
    $_SESSION['errorMsg'] = "Couldn't connect to database";
    header('location:admin.php');
    exit();
}

$UserName = sanitiseString($selectedusername);

//Query to delete the selected user from the database
$sqlQuery = "DELETE FROM Users WHERE UserName='$selectedusername'";
$result = $dbConnection->query($sqlQuery);

//if query unsuccessful return error
if (!$result) {
    $_SESSION['errorMsg'] = "Database connection error" . $dbConnection->error;
}

//close database connection and return to admin page
closeConnection();
header('location:admin.php');

