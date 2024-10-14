<?php 
session_start();
session_unset(); // delete all session variables
session_destroy(); // destroy the active session

header("Location: login.php"); // redirect to the login page
exit(); // stop the script

?>