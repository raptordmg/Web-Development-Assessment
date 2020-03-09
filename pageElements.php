<?php

const HOME = 0;
const SOFTWARE = 1;
const GITHUB = 2;
const ABOUT = 3;
const CONTACT = 4;

function writeMetatags($description) {
    echo '<meta name="author" content="Stephen Wallace">' . "\n";
    echo "<meta name=\"description\" content=\"$description\">\n";
}

function loadCommonStyles() {
    //write later
}

function displayHeader($section)
{
    global $userName;

    echo '<div id="header">';

    if ($userName != '') {
        echo "<span id='userId'> Welcome $userName</span>";
    }

    switch ($section) {
        case HOME:
            echo '<h1>Home</h1>';
            break;
        case SOFTWARE:
            echo '<h1>My Software</h1>';
            break;
        case GITHUB:
            echo '<h1>My Github</h1>';
            break;
        case ABOUT:
            echo '<h1>About</h1>';
            break;
        case CONTACT:
            echo '<h1>Contact</h1>';
            break;
    }
    echo '</div>' . "\n";

    function displayMenu($section)
    {
        $menuItems = array('<a href="index.php" id="Home">Home</a>',
            '<a href="#" id="Software">My Software</a><ul><li><a href="yarrs.php">YARSS</a></li></ul>',
            '<a href="https://github.com/raptordmg" id="GitHub">My GitHub</a>',
            '<a href="about.php" id="About">About</a>',
            '<a href="contact.php" id="Contact">Contact</a>');

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

    function displayFooter()
    {
        echo '<div id="footer"> Stephen Wallace 2020</div>' . "\n";
    }
}