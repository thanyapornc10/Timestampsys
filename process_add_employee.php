<?php 
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: add_employee.php");
    exit();
}

$fname    = trim($_POST['fname'] ?? '');
$lname    = trim($_POST['lname'] ?? '');
$dep      = (int)($_POST['dep'] ?? 0);
$sex      = trim($_POST['sex'] ?? '');
$birth    = trim($_POST['birth'] ?? '');
$email    = trim($_POST['email'] ?? '');
$phone    = trim($_POST['phone'] ?? '');
$address  = trim($_POST['address'] ?? '');
$username = trim($_POST['username'] ?? '');
$userpass = $_POST['password'] ?? '';

$image_path = 'uploads/default.jpg';

if (!empty($_FILES['profile_image']) && $_FILES['profile_image']['error'] === UPLOAD_ERR_OK) {
    $file = $_FILES['profile_image'];
    $allowed = ['jpg', 'jpeg', 'png'];
    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    $size_ok = ($file['size'] <= 5 * 1024 * 1024);
    if (in_array($ext, $allowed) && $size_ok) {
        if (!is_dir('uploads')) { mkdir('uploads', 0777, true); }
        $newname = 'emp_' . uniqid('', true) . '.' . $ext;
        $dest = 'uploads/' . $newname;
        if (move_uploaded_file($file['tmp_name'], $dest)) {
            $image_path = $dest;
        } else {
            echo "Image upload failed (move error)";
            exit();
        }
    } else {
        echo "Invalid image (type/size).";
        exit();
    }
}

$db_host = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "data_time";

$conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);
if (!$conn) { die("DB connection failed: " . mysqli_connect_error()); }

mysqli_begin_transaction($conn);

try {
    $sql_emp = "INSERT INTO employee (fname, lname, dep, sex, birth, email, phone, address, image_path)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql_emp);
    mysqli_stmt_bind_param($stmt, "ssissssss",
        $fname, $lname, $dep, $sex, $birth, $email, $phone, $address, $image_path
    );
    if (!mysqli_stmt_execute($stmt)) {
        throw new Exception("Insert employee failed: " . mysqli_error($conn));
    }
    $emp_id = mysqli_insert_id($conn);

    $sql_user = "INSERT INTO users (users_id, username, password) VALUES (?, ?, ?)";
    $stmt2 = mysqli_prepare($conn, $sql_user);
    mysqli_stmt_bind_param($stmt2, "iss", $emp_id, $username, $userpass);
    if (!mysqli_stmt_execute($stmt2)) {
        throw new Exception("Insert user failed: " . mysqli_error($conn));
    }

    mysqli_commit($conn);

    echo "<script>alert('Employee added successfully.');window.location.href='reportemployee.php';</script>";
    exit();
} catch (Exception $e) {
    mysqli_rollback($conn);
    echo "Error: " . $e->getMessage();
} finally {
    if (isset($stmt)) mysqli_stmt_close($stmt);
    if (isset($stmt2)) mysqli_stmt_close($stmt2);
    mysqli_close($conn);
}
