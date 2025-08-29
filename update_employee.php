<?php
session_start();
if (!isset($_SESSION['useradmin'])) { header("Location: selected.php"); exit(); }
if ($_SERVER['REQUEST_METHOD'] !== 'POST') { header("Location: reportemployee.php"); exit(); }

$host = "localhost";
$usersname = "root";
$password = "";
$database = "data_time";

$conn = new mysqli($host, $usersname, $password, $database);
if ($conn->connect_error) { die("Failed to connect to database: " . $conn->connect_error); }

// รับค่า
$emp_id  = (int)($_POST['emp_id'] ?? 0);
$fname   = trim($_POST['fname'] ?? '');
$lname   = trim($_POST['lname'] ?? '');
$dep     = isset($_POST['dep']) ? (int)$_POST['dep'] : null;
$birth   = $_POST['birth'] ?? null;
$sex     = $_POST['sex'] ?? null;
$email   = trim($_POST['email'] ?? '');
$phone   = trim($_POST['phone'] ?? '');
$address = trim($_POST['address'] ?? '');

if (!$emp_id || !$dep) {
  $conn->close();
  echo "<script>alert('Invalid data'); window.history.back();</script>";
  exit();
}

// อัปโหลดรูป (ออปชันนัล)
$imageSqlPart = "";
$imageParam = null;

if (!empty($_FILES['image']['name'])) {
  $file = $_FILES['image'];
  if ($file['error'] === UPLOAD_ERR_OK) {
    $allowed = ['image/jpeg'=>'jpg','image/png'=>'png'];
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mime  = finfo_file($finfo, $file['tmp_name']);
    finfo_close($finfo);

    if (!isset($allowed[$mime])) { echo "<script>alert('Only JPG/PNG allowed'); history.back();</script>"; exit(); }
    if ($file['size'] > 5*1024*1024) { echo "<script>alert('File too large (>5MB)'); history.back();</script>"; exit(); }

    $ext = $allowed[$mime];
    $newName = "emp_{$emp_id}_".time().".".$ext;
    $uploadDir = __DIR__ . "/uploads";
    if (!is_dir($uploadDir)) { mkdir($uploadDir, 0777, true); }
    $dest = $uploadDir . "/" . $newName;

    if (!move_uploaded_file($file['tmp_name'], $dest)) {
      echo "<script>alert('Upload failed'); history.back();</script>"; exit();
    }

    // เก็บ path สำหรับใช้ในเว็บ
    $publicPath = "uploads/".$newName;
    $imageSqlPart = ", image_path = ?";
    $imageParam = $publicPath;
  } else if ($file['error'] !== UPLOAD_ERR_NO_FILE) {
    echo "<script>alert('Upload error'); history.back();</script>"; exit();
  }
}

// UPDATE
$sql = "UPDATE employee
        SET fname = ?, lname = ?, dep = ?, birth = ?, sex = ?, email = ?, phone = ?, address = ?"
        . $imageSqlPart .
       " WHERE emp_id = ?";

$stmt = $conn->prepare($sql);

if ($imageParam === null) {
  // 9 ตัวแปร -> type string ต้องมี 9 ตัว: s s i s s s s s i
  $stmt->bind_param("ssisssssi", $fname, $lname, $dep, $birth, $sex, $email, $phone, $address, $emp_id);
} else {
  // 10 ตัวแปร -> type string ต้องมี 10 ตัว: s s i s s s s s s i
  $stmt->bind_param("ssissssssi", $fname, $lname, $dep, $birth, $sex, $email, $phone, $address, $imageParam, $emp_id);
}

if ($stmt->execute()) {
  $stmt->close(); $conn->close();
  echo '<script>alert("Successfully edited"); window.location.href="reportemployee.php";</script>';
  exit();
} else {
  $err = $stmt->error; $stmt->close(); $conn->close();
  echo "<script>alert('Update failed: ".htmlspecialchars($err)."'); history.back();</script>";
  exit();
}
