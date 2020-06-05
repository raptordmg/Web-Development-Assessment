<?php
require 'userSession.php';
require 'pageElements.php';
require 'database.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Search Vinyls</title>
    <?php writeCommonStyles(); ?>
    <script src='js\displayError.js'></script>
</head>
<body>
<div id="container">
    <div id="header"><?php displaySignIn(); ?></div>
    <?php displayMenu(SEARCH); ?>

    <div id="content" style="overflow: auto;">
        <?php
        //Displays an error message
        if (isset($_SESSION['errorMsg'])) {
            $errorMsg = $_SESSION['errorMsg'];
            echo "<script>displayError(\"$errMsg\"); </script>";
            unset($_SESSION['errorMsg']);
        } ?>
        <h1>Search for Vinyls here</h1>
        <p>You can search by title, artist or song name</p>
        <form action="search.php" method="get">
            <table>
                <tr>
                    <td><input type="text" name="search" maxlength="30" required>
                    <td><input type="submit" value="Search!"></td>
                </tr>
            </table>
        </form>
        <?php
        //checks if a search has been made and displays the results
        if (isset($_GET['search']) && strlen($_GET['search']) <= 30) {
        echo "<h2>Results...</h2>";
        //connects to signin database
        if (!connectToDb('signin')) {
            $_SESSION['errorMsg'] = "Sorry our database isn't feeling well.\nPlease try again later";
            header('location:search.php');
            exit();
        }

        $user = $_SESSION['userName'];
        $searchQuery = trim($_GET['search']);
        $searchQuery = sanitiseString($searchQuery);

        //Query that inserts user search and userid into database
        $sqlQuery = "INSERT INTO searches (search_term, userid) VALUES ('$searchQuery',(SELECT userid FROM users WHERE username = '$user'))";
        $result = $dbConnection->query($sqlQuery);
        if (!$result) {
            closeConnection();
            $_SESSION['errorMsg'] = "Sorry kour database isn't feeling well.\nPlease try again later";
            exit();
        }
        closeConnection();

        //Connects to the listings database
        if (!connectToDb('listings')) {
            $_SESSION['errorMsg'] = "Sorry our database isn't feeling well.\nPlease try again later";
            header('location:search.php');
            exit();
        }

        //Returns listing data that meets the search criteria
        $sqlQuery = "SELECT id, vinyl_name, artist FROM listings WHERE vinyl_name LIKE '%{$searchQuery}%'OR artist LIKE '%{$searchQuery}%' OR tracklist LIKE '%{$searchQuery}%'";
        $result = $dbConnection->query($sqlQuery);

        //Displays no results
        if ($result->num_rows < 1) {
            closeConnection();
            echo "No results found";
        }
        //Displays the results with a link to the listing page
        else {
        ?>
        <table class="searchResults">
            <?php
            //for each row return display listing data and a link to the listing
            while ($row = $result->fetch_assoc()) {
                $id = $row['id'];
                $vinylName = $row['vinyl_name'];
                $artist = $row['artist'];
                ?>
                <tr>
                    <td><?php echo "<a href='listing.php?id=$id'>$vinylName by $artist</a>" ?></td>
                </tr>
                <?php
            }
            echo "</table>";
            closeConnection();
            }
            }
            ?>

        </div>
</div>
</body>
</html>