<?php
session_start();

ini_set('display_errors', 1);
error_reporting(E_ALL);

if (empty($_SESSION['user_id'])) {
    echo "<script>alert('กรุณาเข้าสู่ระบบ'); location='login.php';</script>";
    exit();
}

$host = "localhost";
$usersname = "root";
$password = "";
$database = "data_time";

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    $conn = new mysqli($host, $usersname, $password, $database);
    $conn->set_charset("utf8mb4");

    $user_id = (int)$_SESSION['user_id'];

    $id      = isset($_POST['id']) ? (int)$_POST['id'] : $user_id;
    if ($id !== $user_id) { throw new Exception("ไม่อนุญาตแก้ไขผู้ใช้อื่น"); }

    $fname   = $_POST['fname']   ?? '';
    $lname   = $_POST['lname']   ?? '';
    $birth   = $_POST['birth']   ?? null;
    $sex     = $_POST['sex']     ?? '';
    $email   = $_POST['email']   ?? '';
    $phone   = $_POST['phone']   ?? '';
    $address = $_POST['address'] ?? '';

    $conn->begin_transaction();

    $sql = "UPDATE employee
            SET fname=?, lname=?, birth=?, sex=?, email=?, phone=?, address=?
            WHERE emp_id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssssi", $fname, $lname, $birth, $sex, $email, $phone, $address, $id);
    $stmt->execute();

    $uploadedImage = false;
    if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] !== UPLOAD_ERR_NO_FILE) {

        if ($_FILES['profile_image']['error'] !== UPLOAD_ERR_OK) {
            throw new Exception("อัปโหลดไฟล์ผิดพลาด (code: ".$_FILES['profile_image']['error'].")");
        }

        $mime = mime_content_type($_FILES['profile_image']['tmp_name']);
        if (!in_array($mime, ['image/jpeg','image/png'])) {
            throw new Exception("อนุญาตเฉพาะ JPG/PNG เท่านั้น");
        }
        if ($_FILES['profile_image']['size'] > 5*1024*1024) {
            throw new Exception("ไฟล์รูปต้องไม่เกิน 5MB");
        }

        $uploadDir = __DIR__ . "/uploads";
        if (!is_dir($uploadDir)) {
            if (!mkdir($uploadDir, 0755, true)) {
                throw new Exception("สร้างโฟลเดอร์อัปโหลดไม่สำเร็จ");
            }
        }

        $ext = strtolower(pathinfo($_FILES['profile_image']['name'], PATHINFO_EXTENSION));
        $newName = "emp_{$id}_" . time() . "." . $ext;
        $targetPath = $uploadDir . "/" . $newName;

        if (!move_uploaded_file($_FILES['profile_image']['tmp_name'], $targetPath)) {
            throw new Exception("ย้ายไฟล์รูปไม่สำเร็จ");
        }

        $relativePath = "uploads/" . $newName;
        $stmt2 = $conn->prepare("UPDATE employee SET image_path=? WHERE emp_id=?");
        $stmt2->bind_param("si", $relativePath, $id);
        $stmt2->execute();

        $uploadedImage = true;
    }

    $conn->commit();

    $msg = "บันทึกสำเร็จ";
    if ($uploadedImage) $msg .= " และอัปโหลดรูปสำเร็จ";
    echo "<script>alert('$msg'); location='profile.php';</script>";
    exit();

} catch (Throwable $e) {
    if (isset($conn) && $conn->errno === 0) {
        $conn->rollback();
    }
    $err = addslashes($e->getMessage());
    echo "<script>alert('บันทึกล้มเหลว: $err'); history.back();</script>";
    exit();
}
