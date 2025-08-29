<?php
// เชื่อมต่อฐานข้อมูล
$servername = "localhost";
$usersname = "root";
$password = "";
$database = "data_time";
$conn = mysqli_connect($servername, $usersname, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

session_start();

if (empty($_SESSION['user_id'])) {
    header("Location: login.php");
}

$user_id = $_SESSION['user_id'];

$sql = "SELECT e.emp_id, e.fname, e.lname, d.dname, e.birth, e.sex ,e.address, e.phone, e.email
                FROM employee e
                LEFT JOIN department d ON e.dep = d.dep_id
                WHERE e.emp_id = $user_id";
$result = $conn->query($sql);

$imageSql = "SELECT image_path FROM employee WHERE emp_id = $user_id";
$imageResult = $conn->query($imageSql);

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8" />
    <title>Profile</title>
    <link rel="stylesheet" href="css/profilest.css" />
    <!-- Boxicons CDN Link -->
    <link href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css" rel="stylesheet" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <style>

    </style>
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
                    <img src="images/default2.jpg" />
                    <div class="name_job">
                        <div class="name">Employee</div>
                        <div class="job">Welcome</div>
                    </div>
                </div>
                <a href="logout.php"><i class="bx bx-log-out" id="log_out"></i></a>
            </li>
        </ul>
    </div>
    <section class="home-section">
        <div class="content">
            <?php if ($imageResult->num_rows == 1) {
                $imageRow = $imageResult->fetch_assoc();
                $imagePath = $imageRow['image_path'];
                echo '<img src="' . $imagePath . '" alt="Employee Image" style="max-width: 200px; max-height: 200px;">';
            } ?>
            <br>
            <?php
            if ($result->num_rows == 1) {
                $row = $result->fetch_assoc();
                // แสดงข้อมูลผู้ใช้
                echo "Employee ID: " . $row['emp_id'] . "<br>";
                echo "Firstname: " . $row['fname'] . "<br>";
                echo "Lastname: " . $row['lname'] . "<br>";
                echo "Department: " . $row['dname'] . "<br>";
                echo "Birthday: " . $row['birth'] . "<br>";
                echo "Gender: " . $row['sex'] . "<br>";
                echo "Address: " . $row['address'] . "<br>";
                echo "Phone: " . $row['phone'] . "<br>";
                echo "Email: " . $row['email'] . "<br>";
            } else {
                echo "No user information founds";
            }
            $conn->close();
            ?>
            <a href='edit_profile.php' class="btn">Edit</a>
        </div>
    </section>
    <script>
        //slidebar
        let sidebar = document.querySelector(".sidebar");
        let closeBtn = document.querySelector("#btn");
        let searchBtn = document.querySelector(".bx-search");
        closeBtn.addEventListener("click", () => {
            sidebar.classList.toggle("open");
            menuBtnChange(); //calling the function(optional)
        });
        searchBtn.addEventListener("click", () => {
            // Sidebar open when you click on the search iocn
            sidebar.classList.toggle("open");
            menuBtnChange(); //calling the function(optional)
        });
        // following are the code to change sidebar button(optional)
        function menuBtnChange() {
            if (sidebar.classList.contains("open")) {
                closeBtn.classList.replace("bx-menu", "bx-menu-alt-right"); //replacing the iocns class
            } else {
                closeBtn.classList.replace("bx-menu-alt-right", "bx-menu"); //replacing the iocns class
            }
        }
    </script>
</body>

</html>