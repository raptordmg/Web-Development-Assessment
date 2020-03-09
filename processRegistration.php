<?php
	if (!isset($_POST['Name']) || !isset($_POST['Username']) || !isset($_POST['email']) || !isset($_POST['password']) || !isset($_POST['ConfirmPassword'])) {
		echo "<p>Error: Missing post data!";
		exit();
	}

	$Name = trim($_POST['Name']);
	$Username = trim($_POST['Username']);
	$Email = trim($_POST['email']);
	$Password = trim($_POST['password']);
	$ConfirmPassword = trim($_POST['ConfirmPassword']);

	if ($Name == '' || $Username == '' || $Email == '' || $Password == '' || $ConfirmPassword == '') {
		echo "<p>Error: Incomplete form data!";
		exit();
	}

	if (!preg_match('/^[a-zA-Z ]*$/', $Name)) {
		echo "<p>Error: Invalid Name Data!";
		exit();
	} elseif (!preg_match('/^[a-zA-Z0-9]*$/', $Username)) {
		echo "<p>Error: Invalid Username Data!";
		exit();
	} elseif (!preg_match('/^\w+@[a-zA-Z_]+?\.[a-zA-Z]{2,3}$/', $Email)) {
		echo "<p>Error: Invalid Email Data!";
		exit();
	} elseif (!preg_match('/^[a-zA-Z]\w{3,14}$/', $Password)) {
		echo "<p>Error: Password is Invalid!";
		exit();
	}

	echo "Thanks for registering $Name!";
?>