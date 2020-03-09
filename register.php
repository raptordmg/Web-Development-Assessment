<!DOCTYPE html>

<html>
	<head>
		<title>Register</title>
	</head>
	<body>
		<div id="container">

			<h1>New User Registration</h1>
		
			<p>Please enter the following details to complete your registration...</p>

			<form action="processRegistration.php" name="registrationForm" method="post">
			<table class="twoColForm">
				<tr><td>Your name:</td><td><input type="text" name="Name"></td></tr>
				<tr><td>Your chosen username:</td><td><input type="text" name="Username"></td></tr>
				<tr><td>Your email address:</td><td><input type="text" name="email"></td></tr>
				<tr><td>Your chosen password:</td><td><input type="password" name="password"></td></tr>
				<tr><td>Confirm your password:</td><td><input type="password" name="ConfirmPassword"></td></tr>
				<tr><td colspan="2"><input type="submit" value="Submit Details"></td></tr>
			</table>
		</form>
	</body>
</html>