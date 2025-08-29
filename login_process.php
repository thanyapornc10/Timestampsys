<?php
session_start();
$servername = "localhost";
$usersname = "root";
$password = "";
$database = "data_time";

// Create connection
$conn = mysqli_connect($servername, $usersname, $password,$database);

// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

    $username = $_POST['username'];
    $password = $_POST['password'];

    // คิวรีเพื่อตรวจสอบข้อมูลผู้ใช้
    $sql = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $_SESSION['user_id'] = $row['users_id'];
        header("Location: profile.php");
    } else {
        echo "Login failed";
    }

    $conn->close();
?>
