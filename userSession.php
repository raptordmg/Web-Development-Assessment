<?php
ini_set('session.use_strict_mode', 1);
session_start();

if(isset($_SESSION['userName'])) {
	$userName = $_SESSION['userName'];
	$pageViews = $_SESSION['pageViews'];
	$pageViews += 1;
	$_SESSION['pageViews'] = $pageViews;
}
else {
	$userName = '';
}


if (isset($_SESSION['password'])) {
		$password = $_SESSION['password'];
	}
	else {
		$password = '';
}
?>