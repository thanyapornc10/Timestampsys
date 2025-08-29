<?php
session_start(); // Start or resume the existing session

$_SESSION = array();

session_destroy();

header("Location: selected.php");
exit;
