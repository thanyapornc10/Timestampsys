<?php
$servername = "localhost";
$usersname = "root";
$password = "";
$database = "data_time";

$conn = mysqli_connect($servername, $usersname, $password, $database);

if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

$useradmin = $_POST['useradmin'];
$password = $_POST['password'];

$sql = "SELECT * FROM adminuser WHERE useradmin='$useradmin' AND password='$password'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  session_start();
  $_SESSION['useradmin'] = $useradmin;
  header("Location: dashboard.php");
} else {
  echo "Login failed";
}

$conn->close();
