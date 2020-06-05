<?php
require 'userSession.php';
require 'pageElements.php';
require 'database.php';
?>

<!DOCTYPE html>

<html lang="en">
    <head>
        <title>Admin Panel</title>
        <?php writeCommonStyles();?>
        <script>
            //Creates a confirm delete box
            function confirmDelete(userName) {
                return confirm("Are you sure you want to delete user " + userName);
            }
        </script>
        <script src="js\displayError.js"></script>
    </head>
    <body>
    <div id="header"><?php displaySignIn(); ?></div>
    <?php displayMenu(ADMIN); ?>

    <div id="content" style="overflow: auto;">
        <h1>User Details:</h1>
        <?php
        //if an error message is set display an error alert
        if (isset($_SESSION['errorMsg'])) {
            $errorMsg = $_SESSION['errorMsg'];
            echo "<script>displayError(\"$errMsg\");</script>";
            unset($_SESSION['errorMsg']);
        }

        //Connects to the database and if it fails display a database error
        if (!connectToDb('signin')) {
            echo "<script>displayErrorDatabase();</script>";
        }
        //Sends a query to the database
        else {
            //Query to return all details of registered users
        $sqlQuery = "SELECT * FROM users ORDER BY UserName";
        $result = $dbConnection->query($sqlQuery);
        //if the database returns less than 1 row display error
        if ($result->num_rows < 1) {
            closeConnection();
            echo "<script>displayErrorDatabase;</script>";
        }
        //Display registered users and some of their details
        else {
        ?>
        <table class="userlist">
            <tr><th>Username</th><th>Real Name</th><th>Email</th><th>Admin</th><th>Actions</th></tr>
            <?php
            //While there are users in the row variable, display the user details
            while($row = $result->fetch_assoc()) {
                $listedusername = $row['UserName'];
                $name = $row['Name'];
                $email = $row['Email'];
                $listedadmin = $row['Admin'];
                ?>
                <tr>
                    <td><?php echo $listedusername; ?></td>
                    <td><?php echo $name; ?></td>
                    <td><?php echo $email; ?></td>
                    <td style="text-align: center"><input type="checkbox" onclick="return false;" <?php if ($listedadmin > 0) echo "checked"; ?>></td>
                    <td>
                        <?php
                        //if the signed in user is not the listed user allow editing and deleting that user
                        if ($listedusername != $userName) {
                            ?>
                            <form style="display: inline;" action="editUser.php" method="post"><input type="hidden" name="username" value="<?php echo $listedusername ?>"><input type="submit" value="Edit..."></form>
                            <form style="display: inline;" action="processDelete.php" onsubmit="return confirmDelete('<?php echo $listedusername ?>');" method="post"><input type="hidden" name="username" value="<?php echo $listedusername ?>"><input type="submit" value="Delete"></form>
                            <?php
                        }
                        ?>
                    </td>
                </tr>
                <?php
            }
            closeConnection();
            }
            }
            ?>
            <?php
            if (!connectToDb('signin')) {
                echo "<script>displayErrorDatabase;</script>";
            }

            //Query that returns a search term and a username from the database
            $sqlQuery = "SELECT search_term, (SELECT username FROM users WHERE users.userid = searches.userid) AS username FROM searches;";
            $result = $dbConnection->query($sqlQuery);
            if ($result->num_rows < 1){
                closeConnection();
                echo "<script>displayErrorDatabase;</script>";
            }

            //Creates a table to display user searches
            else {
            ?>
        </table>
        <h1>User Searches</h1>
        <table class="searchHistory">
            <tr><th>Search term</th><th>Username</th></tr>
            <?php
            //while there are rows in the database results, display search terms and usernames in the table
            while($row = $result->fetch_assoc()) {
                $search = $row['search_term'];
                $searcherUsername = $row['username'];
            ?>
            <tr>
                <td><?php echo $search; ?></td>
                <td><?php echo $searcherUsername; ?></td>
            </tr>
            <?php
            }
            closeConnection();
            }
            ?>
        </table>
    </div>
    <?php displayFooter();?>
    </body>
</html>
