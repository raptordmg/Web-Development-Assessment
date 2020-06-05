<?php
    require 'database.php';

    //Display error if post data not set
	if (!isset($_POST['Name']) || !isset($_POST['Username']) || !isset($_POST['email']) || !isset($_POST['password']) || !isset($_POST['ConfirmPassword']) || !isset($_POST['accountType'])) {
		echo "<p>Error: Missing post data!";
		exit();
	}

	$Name = trim($_POST['Name']);
	$Username = trim($_POST['Username']);
	$Email = trim($_POST['email']);
	$Password = trim($_POST['password']);
	$ConfirmPassword = trim($_POST['ConfirmPassword']);
	$accountType = trim($_POST['accountType']);

	//Checks post data has values
	if ($Name == '' || $Username == '' || $Email == '' || $Password == '' || $ConfirmPassword == '' || $accountType == '') {
		echo "<p>Error: Incomplete form data!";
		exit();
	}

	//Checks post data is valid
	if (!preg_match('/^[a-zA-Z ]*$/', $Name)) {
		echo "<p>Error: Invalid Name Data!";
		exit();
	} elseif (!preg_match('/^[a-zA-Z0-9]*$/', $Username)) {
		echo "<p>Error: Invalid Username Data!";
		exit();
	} elseif (!preg_match('/^\w+@[a-zA-Z0-9_]+?\.[a-zA-Z0-9]{2,3}$/', $Email)) {
		echo "<p>Error: Invalid Email Data!";
		exit();
	} elseif (!preg_match('/^[a-zA-Z0-9]\w{3,14}$/', $Password)) {
		echo "<p>Error: Password is Invalid!";
		exit();
	} elseif (!($accountType == 'personal' || $accountType == 'business')){
	    echo "<p>Error: accountType Invalid";
    }

	//Creates a password hash
	$PwHash = password_hash($Password, PASSWORD_BCRYPT);

	//Connect to signin database
	if (!connectToDb('signin')) {
	    echo '<p>Error: Could not connect to Db';
	    exit();
    }

	$Name = sanitiseString($Name);
	$Username = sanitiseString($Username);
	$Email = sanitiseString($Email);
	$accountType = sanitiseString($accountType);

	//Query gets all user data from the database where the username chosen is equal to an existing username
	$sqlQuery = "SELECT * FROM users WHERE UserName='$Username'";
	$result = $dbConnection->query($sqlQuery);
	if ($result->num_rows > 0) {
	    closeConnection();
	    $_SESSION['errorMsg'] = "Your chosen username '$Username' is already taken";
	    header('location:register.php');
	    exit();
    }

    //Query inserts new user into the database
	$sqlQuery = "INSERT INTO users (Name, UserName, Email, Password, AccountType) VALUES ('$Name', '$Username', '$Email', '$PwHash', '$accountType')";
	$result = $dbConnection->query($sqlQuery);
	if (!$result) {
	    $_SESSION['errorMsg'] = "There was a problem with the database: " . $dbConnection->error;
	    closeConnection();
	    header('location:register.php');
	    exit();
    }

header('location:index.php');
