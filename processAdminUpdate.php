<?php
ini_set('session.use_strict_mode', 1);
session_start();

require 'database.php';

//if username isn't set in session return to index
if (!isset($_SESSION['userName'])) {
    header('location:index.php');
    exit();
}

$username = $_SESSION['userName'];
$adminLevel = $_SESSION['adminLevel'];

//Checks if the user is an admin and signs them out if not
if ($adminLevel < 1) {
    header('location:processSignOut.php');
    exit();
}

//unset the error message
unset($_SESSION['errorMsg']);

//checks the post data is set and if not return user to admin page
if (!(isset($_POST['Name']) && isset($_POST['Username']) && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['accountType']))) {
    header('location:admin.php');
    exit();
}

//assigns variables from post
$name = trim($_POST['Name']);
$postUserName = trim($_POST['Username']);
$email = trim($_POST['email']);
$password = trim($_POST['password']);
$accountType = trim($_POST['accountType']);
//checks if admin is set in post
if (isset($_POST['admin'])) {
    $admin = 1;
} else {
    $admin = 0;
}

//Verifies the email field and if it fails return user to admin page
if (!preg_match('/^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,}$/i', $email)) {
    $_SESSION['errorMsg'] = "The email address isn't valid";
    header('location:admin.php');
    exit();
}

//Connects to the signin database
if (!connectToDb('signin')) {
    $_SESSION['errorMsg'] = "Sorry, couldn't connect to database";
    header('location:details.php');
    exit();
}

//Sanitises the variable from post
$postUserName = sanitiseString($postUserName);
$name = sanitiseString($name);
$email = sanitiseString($email);
$accountType = sanitiseString($accountType);
$admin = sanitiseString($admin);

//if new password is set generate a new hash and creates a query for the database
if ($password != '') {
    $pwHash = password_hash($password, PASSWORD_BCRYPT);
    //Query updates the user details of the targeted user including password
    $sqlQuery = "UPDATE users SET Name='$name', Email='$email', Password='$pwHash', Admin='$admin', AccountType='$accountType' WHERE UserName='$postUserName'";
} else {
    //Query updates the user details of the targeted user excluding password
    $sqlQuery = "UPDATE users SET Name='$name', Email='$email', Admin='$admin', AccountType='$accountType' WHERE UserName='$postUserName'";
}

//Send query to database and returns the result
$result = $dbConnection->query($sqlQuery);

//If result false set error in session
if (!$result) {
    $_SESSION['errorMsg'] = "Database Error";
}

//Close database and return to admin page
closeConnection();
header('location:admin.php');