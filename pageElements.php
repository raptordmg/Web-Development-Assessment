<?php

//Constants to identify each page
const HOME = 0;
const SEARCH = 1;
const NEWLISTING = 2;
const LISTING = 3;
const REGISTER = 4;
const ADMIN = 5;

/*
 * Function to create add metadata to a page
 */
function writeMetatags($description) {
    echo '<meta name="author" content="Stephen Wallace">' . "\n";
    echo "<meta name=\"description\" content=\"$description\">\n";
}

/*
 * Function to add the stylesheets to a page
 */
function writeCommonStyles() {
    ?>
<link href="css/style.css" rel="stylesheet" type="text/css"/>
<link href="css/menu.css" rel="stylesheet" type="text/css"/>
<?php
}

/*
 * Function to display accessibility options
 */
function showAccessibility(){?>
    <script src="js/accessibility.js"></script>
    <table style="border-width: 0;" class="accessibility">
        <tr>
            <td><a href="#" onclick="loadStyle('style');"><img src="img/default.png" alt="Default view"></a></td>
            <td><a href="#" onclick="loadStyle('accessibilitystyle');"><img src="img/highcontrast.png" alt="Accessibility view"></a></td>
        </tr>
    </table>
    <?php
}

/*
 *  Function to display a header text for a page
 */
function displayHeader($section)
{
    global $userName;

    echo '<div id="header">';

    switch ($section) {
        case HOME:
            echo '<h1>Home</h1>';
            break;
        case SEARCH:
            echo '<h1>Search</h1>';
            break;
        case NEWLISTING:
            echo '<h1>Create Listing</h1>';
            break;
        case LISTING:
            echo '<h1>Listing</h1>';
            break;
        case REGISTER:
            echo '<h1>Register</h1>';
            break;
        case ADMIN:
            echo '<h1>Admin portal</h1>';
            break;
    }
    echo '</div>' . "\n";
}

/*
 * Function to display a menu for the website
 */
function displayMenu($section)
{
    //Creates a list of menu items
    $menuItems = array('<a href="index.php" id="home">Home</a>',
        '<a href="search.php" id="search">Search</a>',
        '<a href="newListing.php" id="createListing">Create Listing</a>',
        '<a href="register.php" id="register">Register</a>',
        '<a href="admin.php" id="admin">Admin portal</a>');

    //Creates the html elements used to style a menu
    echo '<nav>
        <ul>';

    $menuCount = count($menuItems);
    for ($i = 0; $i < $menuCount; $i++) {
        echo "\n<li";
        if ($section !== $i) {
        	echo " class='selected'";
        }
        echo ">" . $menuItems[$i];
    }
    echo "\n</ul>
        </nav>";
    }

    /*
     * Function to display a sign in area to a page
     */
function displaySignIn() {
    showAccessibility();
    global $userName;

    //if no one is signed in display the sign in menu
    if ($userName == '') {
        echo '<div id="signin">
            <form action="processLogin.php" name="signInForm" method="post">
            <table>
            <tr>
                <td style="text-align: right">Please enter your username:</td>
                <td><input type="text" name="userName" required></td>
            </tr>
            <tr>
                <td style="text-align: right">Password:</td>
                <td><input type="password" name="pw" required></td>
            </tr>
            <tr>
                <td colspan="2" style="text-align: right"><input type="submit" value="Sign In!"></td>
            </tr>
            </table>
            </form>
            </div>';
    }
    //if user signed in display a sign out button
    else {
        echo '<div id="signout"><form action="processSignOut.php" method="post">Welcome ' . $userName . ' <input type="submit" value="Sign Out"></form></div>';
    }
}

/*
 * Function to display a registration form
 */
function displayRegForm() {
    displayUserForm("processRegistration.php", "registrationForm", "Register",
        "Your name", "",
        "Your email address", "",
        "Your chosen username", "",
        "Your chosen password", "Confirm your password",
        true, -1);
}

/*
 * Function to display the update user details form
 */
function displayUpdateForm($nameValue, $emailValue, $userValue) {
    displayUserForm("processUpdate.php", "updateForm", "Update",
        "Name", $nameValue,
        "Email", $emailValue,
        "Username", $userValue,
        "Password", "Confirm Password",
        false, -1);
}

/*
 * Function to display the admin update user details form
 */
function displayAdminForm($nameValue, $emailValue, $userValue, $adminValue) {
    displayUserForm("processAdminUpdate.php", "updateForm", "Update",
        "Name", $nameValue,
        "Email", $emailValue,
        "User name", $userValue,
        "Password", "Confirm Password",
        false, $adminValue);
}

/*
 * Function to display a user details form
 */
function displayUserForm($postTarget, $formName, $buttonText, $namePrompt, $nameVal, $emailPrompt, $emailVal, $userPrompt, $userValue, $passwordPrompt, $confirmPrompt, $editUser, $adminValue) {
    echo "<script src=\"js\validateForm.js\"></script>";
    echo "<form action=\"$postTarget\" onsubmit=\"return validateRegForm('$formName');\" name=\"$formName\" method=\"post\">\n";
    echo "<table class=\"twoColForm\">\n";
    echo "<tr><td>$namePrompt:</td><td><input type=\"text\" name='Name' required value='$nameVal'></td></tr>\n";
    echo "<tr><td>$userPrompt:</td><td><input type='text' name='Username' required ";

    //Check if form is allowed to edit username
    if (!$editUser) {
        echo "readonly ";
    }
    echo "value=\"$userValue\"></td></tr>\n";
    echo "<tr><td>$emailPrompt:</td><td><input type='text' name='email' required value='$emailVal'></td></tr>";

    //Check if admin value is set and display the admin box
    if ($adminValue >= 0) {
        echo "<tr><td>Admin:</td><td><input type='checkbox' name='admin'";
        //If the admin value is more than 1 check the admin box
        if ($adminValue > 0) echo " checked";
        echo "></td></tr>\n";
    }
    echo "<tr><td>$passwordPrompt:</td><td><input type='password' name='password'";
    //If edituser is true require the password field
    if ($editUser) {
        echo " required";
    }
    echo "></td></tr>\n";
    echo "<tr><td>$confirmPrompt:</td><td><input type='password' name='ConfirmPassword'";
    //If edituser is true require the confirm password field
    if ($editUser) {
        echo " required";
    }
    echo "></td></tr>\n";
    echo "<tr><td>Account Type:</td><td><select name='accountType'>
             <option value='personal'>Personal Account</option>
             <option value='business'>Business Account</option>
          </select></td></tr>";
    echo "<tr><td colspan='2'><input type='submit' onsubmit='validateUserName(\"Username\")' value='$buttonText'></td></tr>\n";
    echo "</table>\n</form>\n";
}

/*
 * Display a form for creating listing
 */
function displayCreateListing() {
    displayModifyListing("processListing.php", "createListing", "", "", "","","", "");
}

/*
 * Display a form for modifying listing
 */
function displayModifyListing($targetPost, $formName, $vinylName, $artist, $price, $quantity, $tracks, $listno) {?>
    <form action="<?php echo $targetPost;?>" name="<?php echo $formName;?>" method="post">
                    <table class="twoColForm">
                        <tr><td>Vinyl name:</td><td><input type="text" name="VinylName" value="<?php echo $vinylName; ?>"></td></tr>
                        <tr><td>Vinyl Artist:</td><td><input type="text" name="Artist" value="<?php echo $artist; ?>"></td></tr>
                        <tr><td>Price:</td><td><input type="text" name="Price" value="<?php echo $price; ?>"></td></tr>
                        <tr><td>Quantity:</td><td><input type="text" name="Quantity" value="<?php echo $quantity; ?>"></td></tr>
                        <tr><td>Track List:</td><td><textarea cols="40"
                                                              id="tracks"
                                                              maxlength="100"
                                                              name="TrackList"
                                                              <?php
                                                              //if tracks is blank set a placeholder
                                                              if ($tracks == '') {
                                                                  echo "placeholder=\"Add the tracknames here and separate them with a space\"";
                                                              }
                                                              //else display the current tracks
                                                              else {
                                                                  echo "value=\"$tracks\"";
                                                              }
                                                              ?>
                                                              rows="4"
                                                              ></textarea></td></tr>
                        <input type="hidden" name="id" value="<?php echo $listno; ?>">
                        <tr><td colspan="2"><input type="submit" value="Submit Listing"></td></tr>
                    </table>
                </form>
    <?php
}

/*
 * Displays a footer
 */
function displayFooter()
{
    echo '<div id="footer"> Stephen Wallace 2020</div>' . "\n";
}