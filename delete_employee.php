<?php
session_start();
if (!isset($_SESSION['useradmin'])) {
    header("Location: selected.php");
    exit();
}

if (isset($_GET['id'])) {
    $employeeId = $_GET['id'];
} else {
    header("Location: reportemployee.php");
    exit();
}
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    echo "Are you sure to delete this data?";
    echo "<a href='delete_employee.php?id=$employeeId&confirm=true'>Agree</a> | ";
    echo "<a href='reportemployee.php'>Cancel</a>";
}

$host = "localhost";
$usersname = "root";
$password = "";
$database = "data_time";

$conn = new mysqli($host, $usersname, $password, $database);

if ($conn->connect_error) {
    die("Failed to connect to database: " . $conn->connect_error);
}

$sql = "DELETE FROM employee WHERE emp_id = $employeeId";

if ($conn->query($sql) === TRUE) {
    header("Location: reportemployee.php");
    exit();
} else {
    echo "An error occurred deleting data: " . $conn->error;
}

$conn->close();
?>
