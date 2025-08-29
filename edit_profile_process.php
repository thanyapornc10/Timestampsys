<?php
session_start();

if (empty($_SESSION['user_id'])) {
    header("Location: login.php");
}

$servername = "localhost";
$usersname = "root";
$password = "";
$database = "data_time";

$conn = mysqli_connect($servername, $usersname, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
$user_id = $_SESSION['user_id'];
$fname = $_POST['fname'];
$lname = $_POST['lname'];
$birth = $_POST['birth'];
$sex = $_POST['sex'];
$address = $_POST['address'];
$phone = $_POST['phone'];
$email = $_POST['email'];

// สร้างคำสั่ง SQL สำหรับการปรับปรุงข้อมูล
$emp_id = $_SESSION['user_id'];
$sql = "UPDATE employee
        SET fname = '$fname', lname = '$lname', birth = '$birth', sex = '$sex', address = '$address', phone = '$phone', email = '$email'
        WHERE emp_id = $emp_id";

if (mysqli_query($conn, $sql)) {
    echo "success";
} else {
    echo "Data editing failed: " . mysqli_error($conn);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // เพิ่มข้อมูลรูปภาพ
    if (isset($_FILES["profile_image"]) && $_FILES["profile_image"]["error"] == 0) {
        $target_dir = "uploads/"; // โฟลเดอร์เก็บไฟล์
        $target_file = $target_dir . basename($_FILES["profile_image"]["name"]);

        // ตรวจสอบไฟล์รูปภาพ
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
            echo "Uploaded images must be image files only (jpg, jpeg, png, gif)";
        } else {
            if (move_uploaded_file($_FILES["profile_image"]["tmp_name"], $target_file)) {
                // บันทึกที่อยู่ของรูปภาพในฐานข้อมูล
                $image_path = $target_file;
                $update_image_sql = "UPDATE employee SET image_path = '$image_path' WHERE emp_id = $user_id";
                if ($conn->query($update_image_sql) === TRUE) {
                    echo "Image uploaded successfully";
                } else {
                    echo "An error occurred while saving the image: " . $conn->error;
                }
            } else {
                echo "There was an error uploading the photo";
            }
        }
    }
}
mysqli_close($conn);
?>
