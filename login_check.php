<?php
// เชื่อมต่อกับฐานข้อมูล
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

// รับข้อมูลจากฟอร์มล็อคอิน
$useradmin = $_POST['useradmin'];
$password = $_POST['password'];

// คิวรี่ฐานข้อมูลเพื่อตรวจสอบข้อมูลผู้ใช้
$sql = "SELECT * FROM adminuser WHERE useradmin='$useradmin' AND password='$password'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // ล็อคอินสำเร็จ
    session_start();
    $_SESSION['useradmin'] = $useradmin;
    header("Location: dashboard.php");
} else {
    // ล็อคอินไม่สำเร็จ
    echo "Login failed";
}

$conn->close();
?>
