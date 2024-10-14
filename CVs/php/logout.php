<?php 
if (session_status() == PHP_SESSION_NONE) { 
    session_start(); 
}

session_unset(); // delete all session variables
session_destroy(); // destroy the active session

session_write_close();

header("Location: home.php"); // redirect to the home page
exit(); // stop the script

?>