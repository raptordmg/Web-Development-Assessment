<?php
ini_set('session.use_strict_mode', 1);
session_start();

//Sets the pages different users can enter
$unsecuredPages = array('index.php', 'register.php');
$adminPages = array('admin.php', 'editDetails.php');

//Checks if the user is signed in and updates the session data
if (isset($_SESSION['userName'])) {
    $userName = $_SESSION['userName'];
    $adminLevel = $_SESSION['adminLevel'];
} else {
    //sets default session data
    $userName = '';
}

//Gets current page
$currentPage = basename($_SERVER['PHP_SELF']);

//Checks if the current page is not an unsecure page
if (!in_array($currentPage, $unsecuredPages)) {
    //If user not signed in return them to index
    if ($userName == '') {
        header('Location: index.php');
        exit();
    }

    else {
        //checks if page is an admin page and signs user out if they're not an admin
        if (in_array($currentPage, $adminPages) && $adminLevel < 1) {
            header('Location:processSignOut.php');
            exit();
        }
    }
}
?>