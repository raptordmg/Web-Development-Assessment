<?php
ini_set('session.use_strict_mode', 1);
session_start();

require 'database.php';

//Checks page id included in post
if (!isset($_POST['id'])) {
    header('location:index.php');
    exit();
}

unset($_SESSION['errorMsg']);

//Connects to the listings database
if (!connectToDb('listings')){
    $_SESSION['errorMsg'] = "Sorry, couldn't connect to database";
    header('location:index.php');
    exit();
}

$id = trim($_POST['id']);
$vinylName = trim($_POST['VinylName']);
$artist = trim($_POST['Artist']);
$price = trim($_POST['Price']);
$quantity = trim($_POST['Quantity']);
$trackList = trim($_POST['TrackList']);

$vinylName = sanitiseString($vinylName);
$artist = sanitiseString($artist);
$price = sanitiseString($price);
$quantity = sanitiseString($quantity);
$trackList = sanitiseString($trackList);
$id = sanitiseString($id);

//Query that updates the details of a listing
$sqlQuery = "UPDATE listings SET vinyl_name = '$vinylName', artist = '$artist', price = '$price', quantity = '$quantity', tracklist = '$trackList' WHERE id = '$id';";
$result = $dbConnection->query($sqlQuery);
if (!$result) {
    $_SESSION['errorMsg'] = "Database Error";
}

closeConnection();
header('location:index.php');
