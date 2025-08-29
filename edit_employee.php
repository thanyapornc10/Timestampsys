<?php
session_start();
if (!isset($_SESSION['useradmin'])) {
    header("Location: selected.php");
    exit();
}

if (isset($_GET['id'])) {
    $employeeId = $_GET['id'];
} else {
    header("Location: report.php");
    exit();
}

// เชื่อมต่อกับฐานข้อมูล
$host = "localhost";
$usersname = "root";
$password = "";
$database = "data_time";

$conn = new mysqli($host, $usersname, $password, $database);

if ($conn->connect_error) {
    die("Failed to connect to database: " . $conn->connect_error);
}

// คิวรี่ฐานข้อมูลเพื่อดึงข้อมูลพนักงาน
$sql = "SELECT employee.emp_id, employee.fname, employee.lname, department.dname, employee.birth, employee.sex, employee.email, employee.phone, employee.address
        FROM employee
        LEFT JOIN department ON employee.dep = department.dep_id
        WHERE employee.emp_id = $employeeId";
$result = $conn->query($sql);

if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
} else {
    header("Location: report.php");
    exit();
}
?>

<!DOCTYPE html>
<html>

<head> <meta charset="UTF-8" />
    <link rel="stylesheet" href="css/editemst.css" />
    <link href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css" rel="stylesheet" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />    
    <title>Edit employees</title>
</head>

<body>
    <section>
        <div class="container">
            <h1>Edit employees</h1>
            <form action="update_employee.php" method="POST">
                <input type="hidden" name="emp_id" value="<?php echo $row['emp_id']; ?>">
                Firstname: <input type="text" name="fname" value="<?php echo $row['fname']; ?>"><br>
                Lastname: <input type="text" name="lname" value="<?php echo $row['lname']; ?>"><br>
                Department:<select name="dname">
                    <option value="1">QA</option>
                    <option value="2">HR</option>
                    <option value="3">CEO</option>
                    <option value="4">SA</option>
                    <option value="5">Sup</option>
                </select><br>
                Birthday: <input type="date" name="birth" value="<?php echo $row['birth']; ?>"><br>
                Gender: <input type="text" name="sex" value="<?php echo $row['sex']; ?>"><br>
                Email: <input type="text" name="email" value="<?php echo $row['email']; ?>"><br>
                Phone: <input type="text" name="phone" value="<?php echo $row['phone']; ?>"><br>
                Adress: <input type="text" name="address" value="<?php echo $row['address']; ?>"><br>
                <button type="submit" id="saveButton">Save</button>
                <button type="button" id="cancelButton" onclick="cancelEdit()">Cancel</button>
            </form>
        </div>
    </section>

    <script>
         function cancelEdit() {
            window.location.href = "reportemployee.php";
        }
    </script>
</body>

</html>