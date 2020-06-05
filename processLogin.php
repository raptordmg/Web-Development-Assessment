<?php
	ini_set('session.use_strict_mode', 1);
	session_start();

	require 'database.php';

	//If user already signed in unset username and admin level
	if(isset($_SESSION['userName'])) {
		unset($_SESSION['userName']);
		unset($_SESSION['adminLevel']);
	}

	//unsets error message
	unset($_SESSION['errorMsg']);

	//if username and password not in post return to index
	if(!(isset($_POST['userName']) && isset($_POST['pw']))) {
		header('location:index.php');
		exit();
	}

	$userName = trim($_POST['userName']);
	$password = trim($_POST['pw']);

	//Checks username is valid
	if (!preg_match('/^[A-Za-z0-9]{1,29}$/', $userName)) {
		$_SESSION['errorMsg'] = "Unexpected user name";
		header('location:index.php');
		exit();
	}

	//connect to the signin database
	if(!connectToDb('signin')) {
		$_SESSION['errorMsg'] = "Couldn't connect to database";
		header('location:index.php');
		exit();
	}

	$userName = sanitiseString($userName);
	//Gets the admin level and and password hash from the database
	$sqlQuery = "SELECT Admin, Password FROM Users WHERE UserName='$userName'";
	$result = $dbConnection->query($sqlQuery);
	//Return an error if result unexpected
	if ($result->num_rows != 1) {
		closeConnection();
		if ($result->num_rows == 0) {
			$_SESSION['errorMsg'] = "Account does not exist";
		}
		else {
			$_SESSION['errorMsg'] = "Unexpected error with database";
		}
		header('location:index.php');
		exit();
	}

	//assigns row to the returned result
	$row = $result->fetch_assoc();
	$pwHash = $row['Password'];
	$adminLevel = $row['Admin'];
	closeConnection();

	//If password verification fails set error
	if (!password_verify($password, $pwHash)) {
		$_SESSION['errorMsg'] = "Incorrect Password!";
	}
	//signs user in
	else {
		$_SESSION['userName'] = $userName;
		$_SESSION['adminLevel'] = $adminLevel;
		unset($_SESSION['signInErr']);
	}

	//Returns user to the index page
	header('Location:index.php');
?>
