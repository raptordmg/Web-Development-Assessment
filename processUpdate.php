<?php
ini_set('session.use_strict_mode', 1);
session_start();

require 'database.php';

//checks user is signed in
if (!isset($_SESSION['userName'])) {
    header('location:index.php');
    exit();
}
$userName = $_SESSION['userName'];

unset($_SESSION['errorMsg']);

//Checks post data is set
if (!(isset($_POST['Name']) && isset($_POST['Username']) && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['accountType']))) {
    header('location:index.php');
    exit();
}

$name = trim($_POST['Name']);
$postUserName = trim($_POST['Username']);
$email = trim($_POST['email']);
$password = trim($_POST['password']);
$accountType = trim($_POST['accountType']);

//Checks email is valid
if (!preg_match('/^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,}$/i', $email)) {
    $_SESSION['errorMsg'] = "Your email address isn't valid";
    header('location:details.php');
    exit();
}

//makes sure user is editing their own details
if ($userName != $postUserName) {
    $_SESSION['errorMsg'] = "Unauthorised Update!";
    header('location:details.php');
    exit();
}

//connects to signin database
if (!connectToDb('signin')) {
    $_SESSION['errorMsg'] = "Sorry, couldn't connect to database";
    header('location:details.php');
    exit();
}

$name = sanitiseString($name);
$email = sanitiseString($email);
$accountType = sanitiseString($accountType);

//if password field not empty include password in query
if ($password != '') {
    //Creates password hash for new password
    $pwHash = password_hash($password, PASSWORD_BCRYPT);
    //Query that updates user details including password
    $sqlQuery = "UPDATE users SET Name='$name', Email = '$email', Password='$pwHash', AccountType='$accountType' WHERE UserName='$userName'";
} else {
    //Query that updates user details including password
    $sqlQuery = "UPDATE Users SET Name='$name', Email = '$email', AccountType='$accountType' WHERE UserName='$userName'";
}
$result = $dbConnection->query($sqlQuery);
if (!$result) {
    $_SESSION['errorMsg'] = "Database Error";
}

closeConnection();
header('location:details.php');