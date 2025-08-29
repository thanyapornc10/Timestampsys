<?php
session_start(); // Start or resume the existing session

// Unset all session variables
$_SESSION = array();

// Destroy the session
session_destroy();

// Redirect the user to the login page or any other page after logging out
header("Location: selected.php"); // Replace "login.php" with the desired page
exit;
?>