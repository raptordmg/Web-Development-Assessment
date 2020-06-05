<?php
    require 'database.php';
    require 'userSession.php';

    /*
     * Function to return an error message
     */
    function postMessage($Error) {
        $_SESSION['errorMsg'] = $Error;
        header('location:newListing.php');
        exit();
    }

    //If post data missing return an error
    if (!isset($_POST['VinylName'])) {
        postMessage("Vinyl Name missing from post");
    } elseif (!isset($_POST['Artist'])) {
        postMessage("Artist missing from post");
    } elseif (!isset($_POST['Price'])) {
        postMessage("Price missing from post");
    } elseif (!isset($_POST['TrackList'])) {
        postMessage("Tracklist missing from post");
    } elseif (!isset($_POST['Quantity'])) {
        postMessage("Quantity missing from post");
    }

    //assigns variables from post
    $vinylName = trim($_POST['VinylName']);
    $artist = trim($_POST['Artist']);
    $price = trim($_POST['Price']);
    $quantity = trim($_POST['Quantity']);
    $trackList = trim($_POST['TrackList']);
    $user = trim($_SESSION['userName']);

    //Checks data from post is valid
    if (!preg_match('/^[a-zA-Z0-9 ]*$/', $vinylName)) {
        postMessage("Vinyl Name contains invalid characters");
    } elseif (!preg_match('/^[a-zA-Z0-9 ]*$/', $artist)){
        postMessage("Artist contains invalid characters");
    } elseif (!preg_match('/^(\d+\.\d{1,2}|\d{1,3})$/',$price)) {
        postMessage("Price is invalid");
    }

    //connects to the signin database
    if(!connectToDb('signin')) {
        postMessage("Sorry our database isn't feeling well.\nPlease try again later");
        exit();
    }

    //sanitises the variables from post
    $vinylName = sanitiseString($vinylName);
    $artist = sanitiseString($artist);
    $price = sanitiseString($price);
    $quantity = sanitiseString($quantity);
    $trackList = sanitiseString($trackList);
    $user = sanitiseString($user);

    //Query that returns the userid
    $sqlQuery = "SELECT userid FROM users WHERE username = '$user'";
    $result = $dbConnection->query($sqlQuery);
    //if now rows returned display error
    if ($result->num_rows == 0) {
        closeConnection();
        postMessage("Not logged in!");
        header('location:index.php');
        exit();
    }
    //Sets sellerID to the userid from the query
    elseif ($result->num_rows == 1) {
        $sellerID = mysqli_fetch_array($result);
        closeConnection();
    }
    //Closes database and displays error message
    else {
        closeConnection();
        postMessage("Database Error");
    }

    //Connects to the listings database
    if (!connectToDb('listings')) {
        postMessage("Sorry our database isn't feeling well.\nPlease try again later");
        exit();
    }

    //Query that adds a listing to the database
    $sqlQuery = "INSERT INTO listings (vinyl_name, artist, seller_id, price, quantity, tracklist) VALUES ('$vinylName', '$artist', '$sellerID[0]', '$price', '$quantity', '$trackList')";
    $result = $dbConnection->query($sqlQuery);
    if (!$result) {
        closeConnection();
        postMessage("Sorry our database isn't feeling well.\nPlease try again later");
    }
    closeConnection();

    postMessage("Listing Created Successfully");
    ?>