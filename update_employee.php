<?php
session_start();
if (!isset($_SESSION['useradmin'])) {
    header("Location: selected.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // เชื่อมต่อกับฐานข้อมูล
    $host = "localhost";
    $usersname = "root";
    $password = "";
    $database = "data_time";

    $conn = new mysqli($host, $usersname, $password, $database);

    if ($conn->connect_error) {
        die("Failed to connect to database: " . $conn->connect_error);
    }

    $emp_id = $_POST['emp_id'];
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $dname = $_POST['dname'];
    $birth = $_POST['birth'];
    $sex = $_POST['sex'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];

    // ทำการอัปเดตข้อมูลพนักงาน
    $sql = "UPDATE employee
            SET fname='$fname', lname='$lname', dep='$dname', birth='$birth', sex='$sex', email='$email', phone='$phone', address='$address'
            WHERE emp_id=$emp_id";

    if ($conn->query($sql) === TRUE) {
        // Close the database connection
        $conn->close();

        // Display an alert and redirect to reportemployee.php
        echo '<script>alert("Successfully edited"); window.location.href = "reportemployee.php";</script>';
        exit();
    } else {
        echo "There was an error updating information: " . $conn->error;
    }

    $conn->close();
}
?>