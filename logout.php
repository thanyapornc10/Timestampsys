<?php
session_start(); // Start or resume

$_SESSION = array();

session_destroy();

header("Location: selected.php");
exit;
