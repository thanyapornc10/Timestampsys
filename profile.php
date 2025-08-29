<?php
$servername = "localhost";
$usersname  = "root";
$password   = "";
$database   = "data_time";
$conn = mysqli_connect($servername, $usersname, $password, $database);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

session_start();
if (empty($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = (int)$_SESSION['user_id'];

$sql = "SELECT e.emp_id, e.fname, e.lname, d.dname, e.birth, e.sex, e.address, e.phone, e.email
        FROM employee e
        LEFT JOIN department d ON e.dep = d.dep_id
        WHERE e.emp_id = $user_id";
$result = $conn->query($sql);
$user = ($result && $result->num_rows === 1) ? $result->fetch_assoc() : null;

$imageSql = "SELECT image_path FROM employee WHERE emp_id = $user_id";
$imageResult = $conn->query($imageSql);
if ($imageResult && $imageResult->num_rows > 0) {
    $imgRow    = $imageResult->fetch_assoc();
    $imagePath = !empty($imgRow['image_path']) ? $imgRow['image_path'] : "images/default2.jpg";
} else {
    $imagePath = "images/default2.jpg";
}
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8" />
    <title>Profile</title>
    <link rel="stylesheet" href="css/profilest.css" />
    <link href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css" rel="stylesheet" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
</head>

<body>
    <div class="sidebar">
        <div class="logo-details">
            <i class="bx bxl-c-plus-plus icon"></i>
            <div class="logo_name">CodingLab</div>
            <i class="bx bx-menu" id="btn"></i>
        </div>
        <ul class="nav-list">
            <li>
                <a href="attendace.php">
                    <i class="bx bx-grid-alt"></i>
                    <span class="links_name">Attendace</span>
                </a>
                <span class="tooltip">Attendace</span>
            </li>
            <li>
                <a href="report.php">
                    <i class="bx bx-pie-chart-alt-2"></i>
                    <span class="links_name">History</span>
                </a>
                <span class="tooltip">History</span>
            </li>
            <li>
                <a href="profile.php">
                    <i class="bx bx-user"></i>
                    <span class="links_name">Profile</span>
                </a>
                <span class="tooltip">Profile</span>
            </li>

            <li class="profile">
                <div class="profile-details">
                    <img src="<?php echo htmlspecialchars($imagePath); ?>" alt="Employee Image" />
                    <div class="name_job">
                        <div class="name"><?php echo htmlspecialchars($user['fname'] ?? 'Employee'); ?></div>
                        <div class="job">Welcome</div>
                    </div>
                </div>
                <a href="logout.php"><i class="bx bx-log-out" id="log_out"></i></a>
            </li>
        </ul>
    </div>

    <section class="home-section">
        <div class="content" style="text-align:center;">
            <img src="<?php echo htmlspecialchars($imagePath); ?>" alt="Employee Image"
                style="max-width:200px; max-height:200px; border-radius:50%; object-fit:cover;">
            <br><br>

            <?php if ($user): ?>
                Employee Image<br>
                Employee ID: <?php echo htmlspecialchars($user['emp_id']); ?><br>
                Firstname: <?php echo htmlspecialchars($user['fname']); ?><br>
                Lastname: <?php echo htmlspecialchars($user['lname']); ?><br>
                Department: <?php echo htmlspecialchars($user['dname']); ?><br>
                Birthday: <?php echo htmlspecialchars($user['birth']); ?><br>
                Gender: <?php echo htmlspecialchars($user['sex']); ?><br>
                Address: <?php echo htmlspecialchars($user['address']); ?><br>
                Phone: <?php echo htmlspecialchars($user['phone']); ?><br>
                Email: <?php echo htmlspecialchars($user['email']); ?><br>
            <?php else: ?>
                No user information found
            <?php endif; ?>

            <br>
            <a href="edit_profile.php" class="btn">Edit</a>
        </div>
    </section>

    <script>
        //slidebar
        let sidebar = document.querySelector(".sidebar");
        let closeBtn = document.querySelector("#btn");
        let searchBtn = document.querySelector(".bx-search");
        closeBtn.addEventListener("click", () => {
            sidebar.classList.toggle("open");
            menuBtnChange();
        });
        if (searchBtn) {
            searchBtn.addEventListener("click", () => {
                sidebar.classList.toggle("open");
                menuBtnChange();
            });
        }

        function menuBtnChange() {
            if (sidebar.classList.contains("open")) {
                closeBtn.classList.replace("bx-menu", "bx-menu-alt-right");
            } else {
                closeBtn.classList.replace("bx-menu-alt-right", "bx-menu");
            }
        }
    </script>
</body>

</html>