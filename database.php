<?php

$dbConnection = null;

$dbErrorCode = null;

/*
 * Creates a simpler way to connect to databases
 */
function connectToDb($dbName) {
    return connectToServerDb('localhost', 'root', 'root', $dbName);
}

/*
 * Handles connecting to the database
 */
function connectToServerDb($serverName, $userName, $password, $dbName) {
    global $dbConnection;
    global $dbErrorCode;

    //Creates a new connection using servername, username, password and database name
    $dbConnection = new mysqli($serverName, $userName, $password, $dbName);

    //If there's a connection error set the error code and returns false
    if ($dbConnection->connect_error) {
        $dbErrorCode = $dbConnection->connect_error;
        $dbConnection = null;
        return false;
    }

    $dbErrorCode = null;
    return true;
}

/*
 * Handles closing the database connection
 */
function closeConnection() {
    global $dbConnection;
    global $dbErrorCode;

    //if the database is connected then close the connection
    if ($dbConnection) {
        $dbConnection->close();
        $dbConnection = null;
        $dbErrorCode = null;
    }
}

/*
 * Takes a string and removes characters that could affect the database
 */
function sanitiseString($input) {
    global $dbConnection;

    //if the database is connected return the string without dangerous characters
    if ($dbConnection) {
        return $dbConnection->real_escape_string(trim($input));
    }
}
?>
