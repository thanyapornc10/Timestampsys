<?php
session_start();
if (empty($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

ini_set('display_errors', 1);
error_reporting(E_ALL);

$servername = "localhost";
$usersname = "root";
$password   = "";
$database   = "data_time";

$conn = new mysqli($servername, $usersname, $password, $database);
$conn->set_charset("utf8mb4");

$user_id = $_SESSION['user_id'];

$sql = "SELECT e.emp_id, e.fname, e.lname, d.dname, e.birth, e.sex, e.address, e.phone, e.email, e.image_path
        FROM employee e
        LEFT JOIN department d ON e.dep = d.dep_id
        WHERE e.emp_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$row = $stmt->get_result()->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8">
  <title>Edit Profile</title>
  <style>
    body{font-family:sans-serif;background:#f2f3f5}
    .card{max-width:720px;margin:40px auto;background:#fff;border-radius:12px;padding:24px;box-shadow:0 8px 24px rgba(0,0,0,.08)}
    .row{display:flex;gap:12px;margin-bottom:12px}
    .row label{width:160px;display:flex;align-items:center;font-weight:600}
    .row input,.row select{flex:1;padding:10px;border:1px solid #ddd;border-radius:8px}
    .img-box{display:flex;align-items:center;gap:16px;margin-bottom:16px}
    .img-box img{width:96px;height:96px;border-radius:50%;object-fit:cover;border:1px solid #ddd}
    .actions{display:flex;gap:12px;justify-content:flex-end;margin-top:16px}
    .btn{padding:10px 16px;border:none;border-radius:8px;cursor:pointer}
    .btn-success{background:#16a34a;color:#fff}
    .btn-danger{background:#ef4444;color:#fff;text-decoration:none;display:inline-block}
  </style>
</head>
<body>
  <div class="card">
    <h2>Edit Profile</h2>

    <div class="img-box">
      <img src="<?= !empty($row['image_path']) ? htmlspecialchars($row['image_path']) : 'uploads/default.jpg' ?>" alt="profile">
      <div>
        <div><small>JPG/PNG (max ~5MB)</small></div>
      </div>
    </div>

    <form action="edit_profile_process.php" method="POST" enctype="multipart/form-data">
      <input type="hidden" name="id" value="<?= htmlspecialchars($row['emp_id']) ?>">

      <div class="row">
        <label>Profile image</label>
        <input type="file" name="profile_image" accept="image/png,image/jpeg">
      </div>

      <div class="row"><label>Firstname</label>
        <input type="text" name="fname" value="<?= htmlspecialchars($row['fname'] ?? '') ?>">
      </div>
      <div class="row"><label>Lastname</label>
        <input type="text" name="lname" value="<?= htmlspecialchars($row['lname'] ?? '') ?>">
      </div>
      <div class="row"><label>Birth</label>
        <input type="date" name="birth" value="<?= htmlspecialchars($row['birth'] ?? '') ?>">
      </div>
      <div class="row"><label>Gender</label>
        <select name="sex">
          <option value="Male"   <?= ($row['sex'] ?? '')==='Male'?'selected':''; ?>>Male</option>
          <option value="Female" <?= ($row['sex'] ?? '')==='Female'?'selected':''; ?>>Female</option>
        </select>
      </div>
      <div class="row"><label>Address</label>
        <input type="text" name="address" value="<?= htmlspecialchars($row['address'] ?? '') ?>">
      </div>
      <div class="row"><label>Phone</label>
        <input type="text" name="phone" value="<?= htmlspecialchars($row['phone'] ?? '') ?>">
      </div>
      <div class="row"><label>Email</label>
        <input type="email" name="email" value="<?= htmlspecialchars($row['email'] ?? '') ?>">
      </div>

      <div class="actions">
        <button class="btn btn-success" type="submit">Save</button>
        <a class="btn btn-danger" href="profile.php">Cancel</a>
      </div>
    </form>
  </div>
</body>
</html>
