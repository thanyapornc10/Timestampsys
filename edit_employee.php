<?php 
session_start();
if (!isset($_SESSION['useradmin'])) { header("Location: selected.php"); exit(); }
if (!isset($_GET['id'])) { header("Location: report.php"); exit(); }

$employeeId = (int)$_GET['id'];

$host = "localhost";
$usersname = "root";
$password = "";
$database = "data_time";

$conn = new mysqli($host, $usersname, $password, $database);
if ($conn->connect_error) { die("Connection failed: " . $conn->connect_error); }

// ดึงข้อมูลพนักงาน
$sql = "SELECT * FROM employee WHERE emp_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $employeeId);
$stmt->execute();
$row = $stmt->get_result()->fetch_assoc();
$stmt->close();

// ดึงแผนกทั้งหมด
$dsql = "SELECT dep_id, dname FROM department ORDER BY dname ASC";
$dresult = $conn->query($dsql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Edit Employee</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body{background:#f6f7f9}
    .container{max-width:800px;margin-top:50px}
    .card{border-radius:15px;padding:40px;box-shadow:0 10px 30px rgba(0,0,0,.1)}
    .title{font-weight:700;font-size:28px;margin-bottom:30px}
    .form-label{font-weight:600}
    .profile-img{width:120px;height:120px;object-fit:cover;border-radius:50%;border:2px solid #ddd}
    .img-box{display:flex;flex-direction:column;align-items:center;gap:10px;margin-bottom:24px}
  </style>
</head>
<body>
<div class="container">
  <div class="card">
    <div class="title">Edit Employee</div>

    <form action="update_employee.php" method="post" enctype="multipart/form-data">
      <input type="hidden" name="emp_id" value="<?= (int)$row['emp_id'] ?>">

      <div class="img-box">
        <?php 
          $img = !empty($row['image_path']) ? $row['image_path'] : 'uploads/default.jpg';
        ?>
        <img id="previewImage" src="<?= htmlspecialchars($img) ?>" alt="profile" class="profile-img" />
        <div><small>JPG/PNG (max ~5MB)</small></div>
        <input type="file" name="image" class="form-control" accept="image/*" onchange="previewFile(event)">
      </div>

      <div class="mb-3">
        <label class="form-label">Firstname</label>
        <input type="text" name="fname" class="form-control" value="<?= htmlspecialchars($row['fname']) ?>" required>
      </div>

      <div class="mb-3">
        <label class="form-label">Lastname</label>
        <input type="text" name="lname" class="form-control" value="<?= htmlspecialchars($row['lname']) ?>" required>
      </div>

      <div class="mb-3">
        <label class="form-label">Department</label>
        <select name="dep" class="form-select" required>
          <?php while ($d = $dresult->fetch_assoc()) { ?>
            <option value="<?= (int)$d['dep_id'] ?>" <?= ($row['dep']==$d['dep_id'])?'selected':'' ?>>
              <?= htmlspecialchars($d['dname']) ?>
            </option>
          <?php } ?>
        </select>
      </div>

      <div class="mb-3">
        <label class="form-label">Birth</label>
        <input type="date" name="birth" class="form-control" value="<?= htmlspecialchars($row['birth']) ?>" required>
      </div>

      <div class="mb-3">
        <label class="form-label">Gender</label>
        <select name="sex" class="form-select" required>
          <option value="Male"   <?= ($row['sex']==='Male')?'selected':'' ?>>Male</option>
          <option value="Female" <?= ($row['sex']==='Female')?'selected':'' ?>>Female</option>
        </select>
      </div>

      <div class="mb-3">
        <label class="form-label">Address</label>
        <input type="text" name="address" class="form-control" value="<?= htmlspecialchars($row['address']) ?>" required>
      </div>

      <div class="mb-3">
        <label class="form-label">Phone</label>
        <input type="text" name="phone" class="form-control" value="<?= htmlspecialchars($row['phone']) ?>" required>
      </div>

      <div class="mb-3">
        <label class="form-label">Email</label>
        <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($row['email']) ?>" required>
      </div>

      <div class="text-end">
        <button type="submit" class="btn btn-success">Save</button>
        <a href="reportemployee.php" class="btn btn-danger">Cancel</a>
      </div>
    </form>
  </div>
</div>
<script>
function previewFile(e){
  const f=e.target.files[0]; if(!f) return;
  const r=new FileReader(); r.onload=()=>document.getElementById('previewImage').src=r.result; r.readAsDataURL(f);
}
</script>
</body>
</html>
