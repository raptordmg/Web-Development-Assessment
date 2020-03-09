<?php
	ini_set('session.use_strict_mode', 1);
	session_start();

	unset($_SESSION['userName']);
	unset($_SESSION['password']);

	if (!isset($_POST['userName']) || !isset($_POST['password'])) {
		header('location: login.php?err="missing POST data"');
		exit();
	}

	if (isset($_SESSION['pageViews'])) {
		$pageViews = $_SESSION['pageViews'];
	} else {
		$pageViews = '0';
	}

	$userName = trim($_POST['userName']);
	$password = trim($_POST['password']);

	if ($userName == '' || $password == '') {
		header('location: login.php?err="incomplete form data"');
		exit();
	}

	if (!preg_match('/^[A-Za-z]*$/', $userName)) {
		header('location: login.php?err="invalid username data"');
		exit();
	}

	$_SESSION['userName'] = $userName;
	$_SESSION['password'] = $password;
	header("location: login.php");
?>
