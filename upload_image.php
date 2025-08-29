<?php
session_start();
if (empty($_SESSION['user_id'])) {
    header("Location: login.php");
}

$target_path = "C:/xampp/htdocs/timestamp/uploads/" . $new_image_name;

if (isset($_POST['upload'])) {
    // เชื่อมต่อฐานข้อมูล
    $host = "localhost";
    $username = "root";
    $password = "";
    $database = "data_time";

    $conn = new mysqli($host, $username, $password, $database);

    if ($conn->connect_error) {
        die("Failed to connect to database: " . $conn->connect_error);
    }

    // ตรวจสอบว่าไฟล์ถูกอัปโหลดหรือไม่
    if (isset($_FILES['image'])) {
        $image = $_FILES['image'];
        $image_name = $image['name'];
        $image_tmp = $image['tmp_name'];

        // สร้างเส้นทางไฟล์ที่จะบันทึก
        $target_path = "uploads/"; // สร้างโฟลเดอร์ uploads ในโฟลเดอร์ของโปรเจกต์

        // ตั้งชื่อไฟล์ใหม่เพื่อป้องกันการซ้ำซ้อน
        $image_extension = pathinfo($image_name, PATHINFO_EXTENSION);
        $new_image_name = uniqid() . "." . $image_extension;

        $target_path = $target_path . $new_image_name;

        // บันทึกรูปภาพในโฟลเดอร์ uploads
        if (move_uploaded_file($image_tmp, $target_path)) {
            // สร้างคำสั่ง SQL เพื่ออัปเดตคอลัมน์ image_path ในฐานข้อมูล
            $emp_id = $_SESSION['user_id'];
            $update_sql = "UPDATE employee SET image_path = '$target_path' WHERE emp_id = $emp_id";

            if ($conn->query($update_sql) === TRUE) {
                // อัปเดตสำเร็จ
                header("Location: profile.php");
                exit();
            } else {
                echo "There was an error updating information: " . $conn->error;
            }
        } else {
            echo "There was an error updating information";
        }
    }
}
?>
