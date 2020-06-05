<?php
ini_set('session.use_strict_mode', 1);
session_start();

//unsets and destroys session
session_unset();
session_destroy();
header('Location:index.php');
?>