<!DOCTYPE html>
<?php
require 'userSession.php'
?>

<html>
	<head>
		<title>Login</title>
	</head>
	<body>
    <div id="header"></div>
        <div id="container">
            <nav>
                <ul>
                    <li><a href="#">Home</a></li>
                    <li><a href="#">My Software</a></li>
                        <ul>
                            <li><a href="#">Yarrs</a> </li>
                            <li><a href="#">Item 1.2</a> </li>
                            <li><a href="#">Item 1.2</a> </li>
                        </ul>
                </ul>
                <li><a href="#">My Github</a>
                <li><a href="#">About</a>
                <li><a href="#">Contact</a></li>
            </nav>
        </div>

    <div id="content"></div>
		<h1>User Login</h1>
		<p>Please enter your username and password to login</p>

		<?php
		if (isset($_GET["err"])) {
			$err = $_GET["err"];
			echo "<h2>Form Error</h2>";
		}
		else if ($userName != '') {
			echo "<p> Welcome back $userName!";
			echo "<p> You have viewed this page $pageViews times!";
		}

		if($userName == '') {?>
			<form action="processLogin.php" onsubmit="return validateForm();" name="signInForm" method="post">
			<table class="twoColForm">
			<tr><td>Please enter username:</td><td><input type="text" name="userName" required></td></tr>
			<tr><td>Please enter your password:</td><td><input type="text" name="password" required></td></tr>
			<tr><td colspan="2"><input type="submit" value="Submit Details"></td></tr>
			</table>
			</form>
			<?php
		}?>
    </div>

    <div id="footer">Stephen Wallace. 2020</div>
	</body>
</html>